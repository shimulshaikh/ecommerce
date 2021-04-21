<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = [
        'parent_id', 'section_id', 'category_name', 'category_image', 'category_discount', 'description', 'url', 'meta_title','meta_description','meta_keywords','status'
    ];


	//For start only Categories 
    public function subcategories()
    {
    	return $this->hasMany('App\Category', 'parent_id')->where('status', 1);
    }

    public function section()
    {
    	return $this->belongsTo('App\Section', 'section_id')->select('id','name');
    }

    public function parentCategory()
    {
    	return $this->belongsTo('App\Category', 'parent_id')->select('id','category_name');
    }

    //For End only Categories 

    public static function catDetails($url)
    {
        $catDetails = Category::select('id','parent_id','category_name','url','description')->with(['subcategories'=>function($query){$query->select('id','parent_id','category_name','url')->where('status',1);
        }])->where('url', $url)->first()->toArray();

        if($catDetails['parent_id']==0)
        {
            //Only show Main category in Brandcrumb
            $brandcrumbs = '<a href="'.url($catDetails['url']).'" >'.$catDetails['category_name'].'</a>';
        }
        else{
            //Show main and sub Category in Brandcrumb
            $parentCategory = Category::select('category_name','url')->where('id',$catDetails['parent_id'])->first()->toArray();
            $brandcrumbs = '<a href="'.url($parentCategory['url']).'" >'.$parentCategory['category_name'].'</a>&nbsp;&nbsp;<a href="'.url($catDetails['url']).'" >'.$catDetails['category_name'].'</a>';
        }
        $catIds = array();
             $catIds[] = $catDetails['id'];

            foreach ($catDetails['subcategories'] as $key => $subcat) {
                $catIds[] = $subcat['id'];
            }
        return array('catIds'=>$catIds, 'catDetails'=>$catDetails, 'brandcrumbs'=>$brandcrumbs);    
    }

}
