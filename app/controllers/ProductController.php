<?php

class ProductController extends Controller
{
    private Product $product;
    private ProductVariant $variant;
    private ProductMedia $media;
    private OptionGroup $optionGroup;
    private OptionValue $optionValue;
    private ServiceType $serviceType;
    private Category $category;
    private Review $review;

    public function __construct()
    {
        parent::__construct();
        $this->product = new Product();
        $this->variant = new ProductVariant();
        $this->media = new ProductMedia();
        $this->optionGroup = new OptionGroup();
        $this->optionValue = new OptionValue();
        $this->serviceType = new ServiceType();
        $this->category = new Category();
        $this->review = new Review();
    }

    public function index(): string
    {
        $filters = [
            'category_id' => $_GET['category'] ?? null,
            'search' => $_GET['search'] ?? null,
            'sort' => $_GET['sort'] ?? null,
        ];

        $data = [
            'title' => 'Sản phẩm',
            'serviceTypes' => $this->serviceType->active(),
            'products' => $this->product->visible($filters),
            'filters' => $filters,
        ];

        return $this->view('frontend/products/index', $data);
    }

    public function show(string $slug): string
    {
        $product = $this->product->findBySlug($slug);
        if (!$product || !$product['is_visible']) {
            http_response_code(404);
            return $this->view('frontend/404', ['title' => 'Không tìm thấy sản phẩm']);
        }

        $groups = $this->optionGroup->forProduct($product['id']);
        foreach ($groups as &$group) {
            $group['values'] = $this->optionValue->forGroup($group['id']);
        }

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'media' => $this->media->forProduct($product['id']),
            'groups' => $groups,
            'reviews' => $this->review->forProduct($product['id']),
            'csrf' => Security::csrfToken(),
        ];

        return $this->view('frontend/products/show', $data);
    }
}

