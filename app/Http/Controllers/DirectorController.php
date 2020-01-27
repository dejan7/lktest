<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Director\StoreDirectorRequest;
use App\Http\Requests\Director\BulkDirectorRequest;
use App\Http\Requests\Director\BulkDeleteDirectorRequest;
use App\Http\Requests\Director\UpdateDirectorRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
use ApiResponse;
use Carbon\Carbon;
use App\Transformers\DirectorTransformer;
use App\Transformers\MovieTransformer;
use App\Http\Requests\Movie\MovieAttachDirectorRequest;
use App\Repositories\Director\IDirectorRepo;
use App\Repositories\Movie\IMovieRepo;

/**
 * @resource Director
 */
class DirectorController extends ResourceController
{
    public function __construct(
        IDirectorRepo $repo,
        DirectorTransformer $transformer,
        IMovieRepo $movieRepo
    ) {
        parent::__construct($repo, $transformer);
        $this->movieRepo = $movieRepo;

        $this->middleware(
            'exists.director',
            ['only' => ['attachMovie', 'detachMovie']]
        );
        $this->middleware(
            'exists.movie:movie_id,true',
            ['only' => ['attachMovie', 'detachMovie']]
        );
    }
    
    /**
     * Create item
     *
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreDirectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectorRequest $request)
    {
        $data = $request->only(array_intersect($request->keys(), $this->repo->getModel()->getFillable()));

        return $this->storeItem($data);
    }

    /**
     * Update item
     *
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateDirectorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectorRequest $request, $id)
    {
        $data = $request->only(array_intersect($request->keys(), $this->repo->getModel()->getFillable()));

        return $this->updateItem($data, $id);
    }

    /**
     * Remove item
     *
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($item = $this->repo->find($id)) {
                $item->delete($id);
                return ApiResponse::ItemDeleted($this->repo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
        
        return ApiResponse::ItemNotFound($this->repo->getModel());
    }

    /**
     * Bulk Insert
     *
     * Bulk insert multiple resources
     *
     * @param  App\Http\Requests\BulkDirectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkInsert(BulkDirectorRequest $request)
    {
        try {
            $input = $request->data;
            $data = [];
            $fillable = array_flip(array_map('value', $this->repo->getModel()->getFillable()));

            foreach ($input as $item) {
                //removing keys which are not fillable!
                $row = array_intersect_key($item, $fillable);
                $row['created_at'] = $row['updated_at'] = Carbon::now();

                $data[] = $row;
            }

            $this->repo->bulk($data);

            return ApiResponse::SuccessMessage(trans('dinkoapi.response_message.succesfully_created'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Bulk Delete
     *
     * Bulk delete multiple resources
     *
     * @param  App\Http\Requests\BulkDirectorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(BulkDeleteDirectorRequest $request)
    {
        try {
            $input = $request->data;
            foreach ($input as $item) {
                $id = $item['id'];
                if ($this->repo->find($id)) {
                    $this->repo->delete($id);
                }
            }

            return ApiResponse::SuccessMessage(trans('dinkoapi.response_message.succesfully_deleted'));
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
    }

    /**
     * Search Movies for Director with given $id
     *
     * Movies from existing resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Dinkara\DinkoApi\Support\ApiResponse
     */
    public function searchMovies(Request $request, $id)
    {
        try {
            if ($item = $this->repo->find($id)) {
                return ApiResponse::Pagination(
                    $this->movieRepo->restSearch($request, $item->movies(null)),
                    new MovieTransformer
                );
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }
        return ApiResponse::ItemNotFound($this->repo->getModel());
    }

    /**
     * Attach Movie
     *
     * Attach the Movie to existing resource.
     *
     * @param  MovieAttachDirectorRequest  $request
     * @param  int  $id
     * @param  int  $movie_id
     * @return \Illuminate\Http\Response
     */
    public function attachMovie(MovieAttachDirectorRequest $request, $id, $movie_id)
    {
        try {
            if ($item = $this->movieRepo->find($movie_id)) {
                $data = $request->only(array_keys($request->rules()));

                $model = $item->getModel();

                return ApiResponse::ItemAttached(
                    $this->repo->find($id)->attachMovie($model, $data)->getModel(),
                    $this->transformer
                );
            } else {
                return ApiResponse::ItemNotFound($this->movieRepo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }

        return ApiResponse::ItemNotFound($this->repo->getModel());
    }

    /**
     * Detach Movie
     *
     * Detach the Movie from existing resource.
     *
     * @param  int  $id
     * @param  int  $movie_id
     * @return \Illuminate\Http\Response
     */
    public function detachMovie($id, $movie_id)
    {
        try {
            if ($item = $this->movieRepo->find($movie_id)) {
                $model = $item->getModel();

                return ApiResponse::ItemDetached($this->repo->find($id)->detachMovie($model)->getModel());
            } else {
                return ApiResponse::ItemNotFound($this->movieRepo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        }

        return ApiResponse::ItemNotFound($this->repo->getModel());
    }
}
