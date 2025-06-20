<?php
namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use PDOException;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}
    public function getCategories(): array
    {
        $categories =[];
        try{
            $categories = $this->categoryRepository->findAll();
        }catch (PDOException $e){
            error_log("Erreur lors de la recherche findAll : " .$e->getMessage());
        }
        return $categories;
    }
    public function getCategoryById(int $id): Category|false
    {
        try {
            return $this->categoryRepository->findById($id);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche par ID : " . $e->getMessage());
            return false;
        }
    }
    public function createCategory(Category $categoryToCreate): bool{
        try{
            $this->categoryRepository->create($categoryToCreate);
            return true;
        } catch(PDOException $e){
            error_log("Erreur lors de la création : " . $e->getMessage());
            return false;
        }
    }
    public function updateCategory(Category $category): bool
    {
        try {
            $this->categoryRepository->update($category);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour : " . $e->getMessage());
            return false;
        }
    }
    public function deleteCategory(Category $category): bool
    {
        try {
            $this->categoryRepository->delete($category);
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression : " . $e->getMessage());
            return false;
        }
    }

}