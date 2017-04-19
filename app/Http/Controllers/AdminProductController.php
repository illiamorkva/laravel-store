<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Instance CategoryRepository.
     *
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Instance ProductRepository.
     *
     * @var ProductRepository
     */
    protected $productRepository;


    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->middleware(['auth','role:admin']);

        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Action for page "Manage products"
     */
    public function actionIndex()
    {
        //Get information about products
        $productsList = $this->productRepository->getProductsList();

        return view('admin_product.index', [
             'productsList' => $productsList
        ]);
    }

    /**
     * Action for page "Add product"
     */
    public function actionCreate(Request $request)
    {
        //Get the list of categories for dropdown
        $categoriesList = $this->categoryRepository->getCategoriesListAdmin();

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required|min:2',
                'code' => 'required|min:2|numeric',
                'price' => 'required|min:2|numeric',
            ]);

            $product = new Product();
            $product->name = $request->input('name');
            $product->code = $request->input('code');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');
            $product->brand = $request->input('brand');
            $product->availability = $request->input('availability');
            $product->description = $request->input('description');
            $product->is_new = $request->input('is_new');
            $product->is_recommended = $request->input('is_recommended');
            $product->status = $request->input('status');

            $id = 0;
            if($product->save()){
                $id = $product->id;
            }

            if ($id) {
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                }
            };

            return redirect("/admin/product");
        }
        return view('admin_product.create', [
            'categoriesList' => $categoriesList
        ]);
    }

    /**
     * Action for page "Update product"
     */
    public function actionUpdate(Request $request, $id)
    {
        //Get the list of categories for dropdown
        $categoriesList = $this->categoryRepository->getCategoriesListAdmin();

        // Get data about current product
        $product = $this->productRepository->getProductById($id);

        if ($request->isMethod('post')) {

            $this->validate($request, [
                'name' => 'required|min:2',
                'code' => 'required|min:2|numeric',
                'price' => 'required|min:2|numeric',
            ]);

            $product->name = $request->input('name');
            $product->code = $request->input('code');
            $product->price = $request->input('price');
            $product->category_id = $request->input('category_id');
            $product->brand = $request->input('brand');
            $product->availability = $request->input('availability');
            $product->description = $request->input('description');
            $product->is_new = $request->input('is_new');
            $product->is_recommended = $request->input('is_recommended');
            $product->status = $request->input('status');

            if($product->save()){
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/products/{$id}.jpg");
                }
            }

            return redirect("/admin/product");
        }
        return view('admin_product.update', [
            'categoriesList' => $categoriesList,
            'product' => $product,
            'id' => $id
        ]);
    }
}
