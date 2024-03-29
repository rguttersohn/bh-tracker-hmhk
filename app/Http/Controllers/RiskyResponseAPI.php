<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CacheKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RiskyResponseAPI extends Controller
{
    use CacheKey;

    protected array $selections = [
        'rr.id',
        'rr.year', 
        'rr.data',
        'gender_constraints.label as sex', 
        'race_constraints.label as race', 
        'sexual_id_constraints.label as sexual_id', 
    ];

    /** bind  query params to column 
     * key is query param
     * value is the associated column
    */

    public function __construct(Request $request)
    {   
        /**run these methods on instantiation */

        $this->setValidQueries($request->all());
        $this->setFilters();
        $this->setSort();
    }

    protected array $allowed_queries = [
        'id' =>'rr.id', 
        'year' => 'year',  
        'race' => 'race_constraints.slug',
        'sexual_id' => 'sexual_id_constraints.slug', 
        'sex' => 'gender_constraints.slug',
        'sort_asc' => 'asc',
        'sort_desc' => 'desc',
    ];


    protected array $valid_queries = [];

    protected array $filters = [];

    protected array $sort = [];


    /** 
     * checks the url queries against the the allowed queriest list
     */
    protected function setValidQueries(array $queries):void {
        
        
        foreach($queries as $key => $value):

            if(isset($this->allowed_queries[$key])):

                $this->valid_queries[$key] = $value;
            
            endif;

        endforeach;

    }

    /**
     * use getValidQueries to check the queries
     * then check the queries to make sure they are filters and not a sort_desc or sort_asc queries.
     * 
     */

    protected function setFilters():void {
        
        $validated_queries = $this->valid_queries;
        
        foreach($validated_queries as $key => $value):

            if(str_starts_with($key, 'sort_asc') || str_starts_with($key, 'sort_desc')):
                
                continue;
            
            endif;

            array_push($this->filters, [$this->allowed_queries[$key], '=', $value]);

          
        endforeach;

    }

    protected function getFilters():array{
        return $this->filters;
    }

    protected function setSort():void {


        $validated_queries = $this->valid_queries;
        foreach($validated_queries as $key => $value):
            if($key === "sort_desc" || $key === "sort_asc"):
                
                $this->sort['order_by'] = $value;

                $this->sort['direction'] = $this->allowed_queries[$key]; 
                
            endif;

            continue;
            
            
        endforeach;

    }

    protected function getSort():array{
        return $this->sort;
    }

    
    protected function stagingResponsesQuery(string $id):array{
        
        $query = DB::table('risky_responses as rr')
            ->where([['publication_status', '=', 'staging'], ['rr.risky_question_id', '=', $id], ... $this->getFilters()])
            ->orWhere([['publication_status', '=', 'production'], ['rr.risky_question_id', '=', $id], ... $this->getFilters()])
            ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
            ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
            ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
            ->select(...$this->selections);

        if(!empty($this->getSort())):
            
            $query->orderBy($this->getSort()['order_by'], $this->getSort()['direction']);
        
        endif;
          
        return $query->get()->toArray();
    }

    protected function productionResponsesQuery(string $id):array{

        $query = DB::table('risky_responses as rr')
            ->where([['publication_status', '=', 'production'], ['rr.risky_question_id', '=', $id], ... $this->getFilters()])
            ->join('gender_constraints', 'rr.gender_constraint_id', '=', 'gender_constraints.id')
            ->join('race_constraints', 'rr.race_constraint_id', '=', 'race_constraints.id')
            ->join('sexual_id_constraints', 'rr.sexual_id_constraint_id', '=', 'sexual_id_constraints.id')
            ->select(...$this->selections);
        
        if(!empty($this->getSort())):
        
            $query->orderBy($this->getSort()['order_by'], $this->getSort()['direction']);
        
        endif;

        return $query->get()->toArray();

    }

    public function getResponses( string $env, string $id):array {

        $cache_query = static::setRiskKeys($env, $id, 'responses', $this->valid_queries);

        $cached_data = Redis::get($cache_query);

        if($cached_data):
            return json_decode($cached_data);
        endif;

        $responses_query = match($env){
            'staging' => $this->stagingResponsesQuery($id),
            'production' => $this->productionResponsesQuery($id),
            default => []
        };

        Redis::set($cache_query, json_encode($responses_query));

        return $responses_query;
    
    }

}
