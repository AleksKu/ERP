<?php

namespace Torg\Http\Controllers\API;

use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Torg\Http\Controllers\AppBaseController;
use Torg\Http\Requests\API\CreateStockAPIRequest;
use Torg\Http\Requests\API\UpdateStockAPIRequest;
use Torg\Stocks\Repositories\StockRepository;
use Torg\Stocks\Stock;

/**
 * Class StockController
 * @package Torg\Http\Controllers\API
 */
class StockAPIController extends AppBaseController
{
    /** @var  StockRepository */
    private $stockRepository;

    /**
     * StockAPIController constructor.
     *
     * @param StockRepository $stockRepo
     */
    public function __construct(StockRepository $stockRepo)
    {
        $this->stockRepository = $stockRepo;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/stocks",
     *      summary="Get a listing of the Stocks.",
     *      tags={"Stock"},
     *      description="Get all Stocks",
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
     *                  @SWG\Items(ref="#/definitions/Stock")
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
        $this->stockRepository->pushCriteria(new RequestCriteria($request));
        $this->stockRepository->pushCriteria(new LimitOffsetCriteria($request));
        $stocks = $this->stockRepository->all();

        return $this->sendResponse($stocks->toArray(), 'Stocks retrieved successfully');
    }

    /**
     * @param CreateStockAPIRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Post(
     *      path="/stocks",
     *      summary="Store a newly created Stock in storage",
     *      tags={"Stock"},
     *      description="Store Stock",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Stock that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Stock")
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
     *                  ref="#/definitions/Stock"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStockAPIRequest $request)
    {
        $input = $request->all();

        $stocks = $this->stockRepository->create($input);

        return $this->sendResponse($stocks->toArray(), 'Stock saved successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @SWG\Get(
     *      path="/stocks/{id}",
     *      summary="Display the specified Stock",
     *      tags={"Stock"},
     *      description="Get Stock",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Stock",
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
     *                  ref="#/definitions/Stock"
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
        /** @var Stock $stock */
        $stock = $this->stockRepository->find($id);

        if (empty($stock)) {
            return Response::json(ResponseUtil::makeError('Stock not found'), 400);
        }

        return $this->sendResponse($stock->toArray(), 'Stock retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateStockAPIRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     * @SWG\Put(
     *      path="/stocks/{id}",
     *      summary="Update the specified Stock in storage",
     *      tags={"Stock"},
     *      description="Update Stock",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Stock",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Stock that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Stock")
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
     *                  ref="#/definitions/Stock"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStockAPIRequest $request)
    {
        $input = $request->all();

        /** @var Stock $stock */
        $stock = $this->stockRepository->find($id);

        if (empty($stock)) {
            return Response::json(ResponseUtil::makeError('Stock not found'), 400);
        }

        $stock = $this->stockRepository->update($input, $id);

        return $this->sendResponse($stock->toArray(), 'Stock updated successfully');
    }

    /**
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/stocks/{id}",
     *      summary="Remove the specified Stock from storage",
     *      tags={"Stock"},
     *      description="Delete Stock",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Stock",
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
        /** @var Stock $stock */
        $stock = $this->stockRepository->find($id);

        if (empty($stock)) {
            return Response::json(ResponseUtil::makeError('Stock not found'), 400);
        }

        $stock->delete();

        return $this->sendResponse($id, 'Stock deleted successfully');
    }
}
