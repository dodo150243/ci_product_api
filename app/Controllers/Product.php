<?php namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;


class Product extends ResourceController{
    use ResponseTrait;
    // Method GET
    // Get all product
    public function index(){
        $model = new ProductModel();
        $data['products'] = $model->orderBy('_id',"DESC")->findAll();
        return $this->respond($data['products']);
    }

    public function getProductById($id = null){
        $model = new ProductModel();
        $data = $model->where('_id',$id)->first();
        if($data){
            return $this->respond($data);
        }
        else{
            return $this->failNotFound('No product found!');
        }
    }

    // Methot POST
    public function create(){
        $model = new ProductModel();
        
        $data = [
            'name'=> $this->require->getVar('name'),
            'category'=> $this->require->getVar('category'),
            'price'=> $this->require->getVar('price'),
            'tags'=> $this->require->getVar('tags'),
        ];
        $data = $model->insert($data);
        $myRespond =[
            "status"=> 201,
            "error" => null,
            "messages" => "Product inserted successfully"
        ];
        return $this->respond($myRespond);
    }

    // Methot PUT
    public function update($id=null){
        $model = new ProductModel();
        $data = [
            'name'=> $this->require->getVar('name'),
            'category'=> $this->require->getVar('category'),
            'price'=> $this->require->getVar('price'),
            'tags'=> $this->require->getVar('tags'),
        ];
        $model->where('_id',$id)->set($data)->update();
        $myRespond =[
            "status"=> 201,
            "error" => null,
            "messages" => "Product updated successfully"
        ];
        return $this->respond($myRespond);
    }

    // Methot DELETE
    public function delete($id=null)
    {
        $model = new ProductModel();
        $check = $model->where('_id',$id)->first();
        if($check){
            $model->delete($id);
            
        }
    }
}

