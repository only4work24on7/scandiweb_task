<?php
class Type extends ProductController
{
    public static $errors = [];

    public function productValidate()
    {
        AddProductRequest::validate([
            'sku' => [
                'required' => [],
                'unique' => ['product']
            ],
            'name' => [
                'required' => [],
            ],
            'price' => [
                'required' => [],
                'digits' => [],
            ],
            'type' => [
                'required' => [],
                'TypeR' => [],
            ],
        ]);
        if (!count(AddProductRequest::getErrors()) == 0) {
            $errors = AddProductRequest::getErrors();
            // $e = json_encode($errors,JSON_FORCE_OBJECT);
            return $errors;
        }
    }
}
?>