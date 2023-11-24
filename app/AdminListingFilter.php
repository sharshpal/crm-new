<?php

namespace App;

use Brackets\AdminListing\AdminListing;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminListingFilter extends AdminListing
{
    /**
     * Process request and get data
     *
     * You should always specify an array of columns that are about to be queried
     *
     * You can specify columns which should be searched
     *
     * If you need to include additional filters, you can manage it by
     * modifying a query using $modifyQuery function, which receives
     * a query as a parameter.
     *
     * If your model has translations, you can specify locale which should be loaded.
     * When searching and ordering, this locale will be appended to the query in appropriate places as well.
     *
     * This method does not perform any authorization nor validation.
     *
     * @param Request $request
     * @param array $columns
     * @param array $searchIn array of columns which should be searched in (only text, character varying or primary key are allowed)
     * @param callable $modifyQuery
     * @param string $locale
     * @return LengthAwarePaginator|Collection The result is either LengthAwarePaginator (when pagination was attached) or simple Collection otherwise
     * @throws Exception
     */
    function processRequestAndGet(Request $request, array $columns = ['*'], $searchIn = null, callable $modifyQuery = null, $locale = null, $dropdownFilters = [], $forceBulk = false, $customConnection = null)
    {

        if($customConnection){
            $this->model->setConnection($customConnection);
            $this->query = $this->model->newQuery();
        }

        // process all the basic stuff
        $this->attachOrdering($request->input('orderBy', $this->model->getKeyName()), $request->input('orderDirection', 'asc'))
            ->attachSearch($request->input('search', null), $searchIn);

        // we want to attach pagination if bulk filter is disabled or not forced otherwise we want to select all data without pagination
        if (!$request->input('bulk') && !$forceBulk) {
            $this->attachPagination($request->input('page', 1), $request->input('per_page', $request->cookie('per_page', 10)));
        }

        // add custom modifications
        if ($modifyQuery !== null) {
            $this->modifyQuery($modifyQuery);
        }

        // add custom dropdown filters
        // TODO make it generic . ugly but works with 4 levels level1.level2.level3.level4
        if ($dropdownFilters !== null) {
            $dropdownQuery = function ($query) use ($request, $dropdownFilters) {
                foreach ($dropdownFilters as $dropdownFilter) {
                    $keys = explode('.', $dropdownFilter);
                    if (count($keys) == 1) {
                        $key = $keys[0];
                        if ($request->has($key)) {
                            $input = $request->input($key);
                            if (is_array($input)) $query->whereIn($key, $input);
                            else $query->where($key, $input);
                        }
                    } else if (count($keys) == 2) {
                        $whereHas = $keys[0];
                        $key = $keys[1];
                        if ($request->has($key) || $request->has($whereHas . '.' . $key)) {
                            $query->whereHas($whereHas, function ($query) use ($request, $whereHas, $key) {
                                // TODO if many2many is needed on level3+ adapt others to this with ($whereHas.'.'.$key) composite keys
                                $input = $request->has($whereHas . '.' . $key) ? $request[$whereHas . '.' . $key] : $request->input($key);

                                if (is_array($input)) $query->whereIn($key, $input);
                                else $query->where($key, $input);
                            });
                        }
                    } else if (count($keys) == 3) {
                        $whereHasOuter = $keys[0];
                        $whereHasInner = $keys[1];
                        $key = $keys[2];
                        $query->whereHas($whereHasOuter, function ($query) use ($request, $whereHasInner, $key) {
                            $query->whereHas($whereHasInner, function ($query) use ($request, $key) {
                                if ($request->has($key)) {
                                    $input = $request->input($key);
                                    if (is_array($input)) $query->whereIn($key, $input);
                                    else $query->where($key, $input);
                                }
                            });
                        });
                    } else if (count($keys) == 4) {
                        $whereHasOuterOuter = $keys[0];
                        $whereHasOuter = $keys[1];
                        $whereHasInner = $keys[2];
                        $key = $keys[3];
                        $query->whereHas($whereHasOuterOuter, function ($query) use ($request, $whereHasOuter, $whereHasInner, $key) {
                            $query->whereHas($whereHasOuter, function ($query) use ($request, $whereHasInner, $key) {
                                $query->whereHas($whereHasInner, function ($query) use ($request, $key) {
                                    if ($request->has($key)) {
                                        $input = $request->input($key);
                                        if (is_array($input)) $query->whereIn($key, $input);
                                        else $query->where($key, $input);
                                    }
                                });
                            });
                        });
                    } else {
                        throw new Exception("FIX ME!!! i need one more key");
                    }
                }
            };
            $this->modifyQuery($dropdownQuery);

            // TODO make it generic (see code on top)
            /*foreach ($dropdownFilters as $dropdownFilter) {
                $modifyQuery = $this->incapsulate($dropdownFilter, $modifyQuery, $request);
                $this->modifyQuery($modifyQuery);
            }*/
        }

        if ($locale !== null) {
            $this->setLocale($locale);
        }


        // if bulk filter is enabled we want to get only primary keys
        /*
        if ($request->input('bulk') || $forceBulk) {
            return $this->get(['id']);
        }
        */

        // execute query and get the results
        return $this->get($columns);
    }
    /* TODO
    function incapsulate($keys, $query, $request)
    {
        $data = explode('.', $keys);

        if (count($data) > 1) {

            $whereHas = $data[0];
            unset($data[0]);
            $keys = join('.', $data);

            die($keys);
            return $query->whereHas($whereHas, $this->incapsulate($keys, $query, $request));
        } else {
            $key = $data[0];

            if ($request->has($key)) {
                $input = $request->input($key);
                if (is_array($input)) {
                    dd($query);
                    return $query->whereIn($key, $input);
                } else {
                    dd($query);
                    return $query->where($key, $input);
                }
            }
        }
    }
    */
}
