<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreatePageAPIRequest;
use App\Http\Requests\API\Admin\UpdatePageAPIRequest;
use App\Models\Page;
use App\Repositories\Admin\PageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PageController
 */

class PageAPIController extends AppBaseController
{
    private PageRepository $pageRepository;

    public function __construct(PageRepository $pageRepo)
    {
        $this->pageRepository = $pageRepo;
    }

    /**
     * @OA\Get(
     *      path="/admin/pages",
     *      summary="getPageList",
     *      tags={"Page"},
     *      description="Get all Pages",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Page")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $pages = $this->pageRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/admin/pages",
     *      summary="createPage",
     *      tags={"Page"},
     *      description="Create Page",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Page")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Page"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $page = $this->pageRepository->create($input);

        return $this->sendResponse($page->toArray(), 'Page saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/admin/pages/{id}",
     *      summary="getPageItem",
     *      tags={"Page"},
     *      description="Get Page",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Page",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Page"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Page $page */
        $page = $this->pageRepository->find($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        return $this->sendResponse($page->toArray(), 'Page retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/admin/pages/{id}",
     *      summary="updatePage",
     *      tags={"Page"},
     *      description="Update Page",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Page",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Page")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Page"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Page $page */
        $page = $this->pageRepository->find($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        $page = $this->pageRepository->update($input, $id);

        return $this->sendResponse($page->toArray(), 'Page updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/admin/pages/{id}",
     *      summary="deletePage",
     *      tags={"Page"},
     *      description="Delete Page",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Page",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Page $page */
        $page = $this->pageRepository->find($id);

        if (empty($page)) {
            return $this->sendError('Page not found');
        }

        $page->delete();

        return $this->sendSuccess('Page deleted successfully');
    }
}
