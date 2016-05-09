<?php

namespace Torg\Http\Controllers\API;

use Torg\Http\Requests\API\CreateStockReserveAPIRequest;
use Torg\Http\Requests\API\UpdateStockReserveAPIRequest;
use Torg\Stocks\StockReserve;
use Torg\Repositories\StockReserveRepository;
use Illuminate\Http\Request;
use Torg\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StockReserveController
 * @package Torg\Http\Controllers\API
 */

class StockReserveAPIController extends AppBaseController
{
    /** @var  StockReserveRepository */
    private $stockReserveRepository;

    public function __construct(StockReserveRepository $stockReserveRepo)
    {
        $this->stockReserveRepository = $stockReserveRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/stockReserves",
     *      summary="Get a listing of the StockReserves.",
     *      tags={"StockReserve"},
     *      description="Get all StockReserves",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/StockReserve")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->stockReserveRepository->pushCriteria(new RequestCriteria($request));
        $this->stockReserveRepository->pushCriteria(new LimitOffsetCriteria($request));
        $stockReserves = $this->stockReserveRepository->all();

        return $this->sendResponse($stockReserves->toArray(), 'StockReserves retrieved successfully');
    }

    /**
     * @param CreateStockReserveAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/stockReserves",
     *      summary="Store a newly created StockReserve in storage",
     *      tags={"StockReserve"},
     *      description="Store StockReserve",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StockReserve that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StockReserve")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/StockReserve"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStockReserveAPIRequest $request)
    {
        $input = $request->all();

        $stockReserves = $this->stockReserveRepository->create($input);

        return $this->sendResponse($stockReserves->toArray(), 'StockReserve saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/stockReserves/{id}",
     *      summary="Display the specified StockReserve",
     *      tags={"StockReserve"},
     *      description="Get StockReserve",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StockReserve",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/StockReserve"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var StockReserve $stockReserve */
        $stockReserve = $this->stockReserveRepository->find($id);

        if (empty($stockReserve)) {
            return Response::json(ResponseUtil::makeError('StockReserve not found'), 400);
        }

        return $this->sendResponse($stockReserve->toArray(), 'StockReserve retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStockReserveAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/stockReserves/{id}",
     *      summary="Update the specified StockReserve in storage",
     *      tags={"StockReserve"},
     *      description="Update StockReserve",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StockReserve",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="StockReserve that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/StockReserve")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/StockReserve"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStockReserveAPIRequest $request)
    {
        $input = $request->all();

        /** @var StockReserve $stockReserve */
        $stockReserve = $this->stockReserveRepository->find($id);

        if (empty($stockReserve)) {
            return Response::json(ResponseUtil::makeError('StockReserve not found'), 400);
        }

        $stockReserve = $this->stockReserveRepository->update($input, $id);

        return $this->sendResponse($stockReserve->toArray(), 'StockReserve updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/stockReserves/{id}",
     *      summary="Remove the specified StockReserve from storage",
     *      tags={"StockReserve"},
     *      description="Delete StockReserve",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of StockReserve",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var StockReserve $stockReserve */
        $stockReserve = $this->stockReserveRepository->find($id);

        if (empty($stockReserve)) {
            return Response::json(ResponseUtil::makeError('StockReserve not found'), 400);
        }

        $stockReserve->delete();

        return $this->sendResponse($id, 'StockReserve deleted successfully');
    }
}
