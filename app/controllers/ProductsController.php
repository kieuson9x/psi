<?php
class ProductsController extends Controller
{
    private $db;
    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    public function search()
    {
        $keyword = strval($_POST['query'] ?? '');
        $productResult = [];

        $search_param = "%{$keyword}%";

        $products = $this->productModel->searchProducts($search_param);

        $productOptions = array_map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        }, $products);

        echo json_encode($productOptions);
    }
}
