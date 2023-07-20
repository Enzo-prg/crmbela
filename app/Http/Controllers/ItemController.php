<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Queries\ItemDataTable;
use App\Repositories\ItemRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ItemController extends AppBaseController
{
    /** @var ItemRepository */
    private $itemRepository;

    public function __construct(ItemRepository $itemRepo)
    {
        $this->itemRepository = $itemRepo;
    }

    /**
     * Display a listing of the Item.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ItemDataTable())->get($request->only(['group'])))->make(true);
        }

        $data = $this->itemRepository->getSyncListForItem();

        return view('items.index', compact('data'));
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param  CreateItemRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateItemRequest $request)
    {
        $input = $request->all();
        $input['rate'] = removeCommaFromNumbers($input['rate']);

        $product = $this->itemRepository->create($input);

        activity()->performedOn($product)->causedBy(getLoggedInUser())
            ->useLog('New Product created.')->log($product->title.' Product created.');

        return $this->sendSuccess('Product saved successfully.');
    }

    /**
     * Show the form for editing the specified Item.
     *
     * @param  Item  $item
     *
     * @return JsonResponse
     */
    public function edit(Item $item)
    {
        $item = $this->itemRepository->getItem($item->id);

        return $this->sendResponse($item, 'Product retrieved successfully.');
    }

    /**
     * Update the specified Item in storage.
     *
     * @param  Item  $item
     *
     * @param  UpdateItemRequest  $request
     *
     * @return JsonResponse
     */
    public function update(Item $item, UpdateItemRequest $request)
    {
        $input = $request->all();
        $input['rate'] = removeCommaFromNumbers($input['rate']);

        $product = $this->itemRepository->update($input, $item->id);

        activity()->performedOn($product)->causedBy(getLoggedInUser())
            ->useLog('Product updated.')->log($product->title.' Product updated.');

        return $this->sendSuccess('Product updated successfully.');
    }

    /**
     * Remove the specified Item from storage.
     *
     * @param  Item  $item
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Item $item)
    {
        activity()->performedOn($item)->causedBy(getLoggedInUser())
            ->useLog('Product deleted.')->log($item->title.' Product deleted.');

        $item->delete();

        return $this->sendSuccess('Product deleted successfully.');
    }
}
