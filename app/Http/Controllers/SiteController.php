<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
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
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Action for main page
     */
    public function actionIndex()
    {
        //List of categories for the left menu
        $categories = $this->categoryRepository->getCategoriesList();

        //List of latest products
        $latestProducts = $this->productRepository->getLatestProducts(6);

        //List of products for the slider
        $sliderProducts = $this->productRepository->getRecommendedProducts();

        return view('site.index', [
            'categories' => $categories, 'latestProducts' => $latestProducts, 'sliderProducts' => $sliderProducts
        ]);
    }

    /**
     * Action for contacts page
     */
    public function actionContact(Request $request)
    {
        // Variables for the form
        $userEmail = false;
        $userText = false;
        $result = false;

        // Form processing
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'userEmail' => 'required|email',
            ]);

            $userEmail = $request->input('userEmail');
            $userText = $request->input('userText');

            // Отправляем письмо администратору
            $adminEmail = 'email@yandex.ua';
            $message = "Текст: {$userText}. От {$userEmail}";
            $subject = 'Тема письма';
            //$result = mail($adminEmail, $subject, $message);
            $result = true;
        }

        return view('site.contact',[
            'result' => $result, 'userEmail' => $userEmail, 'userText' => $userText
        ]);
    }

    /**
     * Action for the page "About the store"
     */
    public function actionAbout()
    {
        return view('site.about');
    }
}
