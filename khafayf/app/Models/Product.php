<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, Translatable;

    public $table = 'products';
    public $translationModel = 'App\Models\ProductTranslations';

    public $translatedAttributes = ['name','description'];
    protected $fillable = ['user_id','cat_id','subcat_id','price','price_over','number_peces','available','slider','home_page','main_image','status'];

    protected $hidden = ['created_at','updated_at','deleted_at','home_page','slider'];
    
    protected $appends = ['is_favourite','is_rate','user_name','color_features','name_en','name_ar','description_en','description_ar','price_min','offer_Price'];



    public function getMainImageAttribute($image)
        {
            if (!is_null($image)) {
                    return url($image);
                }
                return "";
        }

         public function getImageAttribute($image)
        {
            if (!is_null($image)) {
                    return url($image);
                }
                return "";
        }
    
   
    public function getIsFavouriteAttribute()
        {
            if (auth('api')->check()) {
                return Favourit::where('user_id',auth('api')->id())->where('product_id',$this->id)->count();
            }
            return 0;
        }
        

    public function getIsRateAttribute()
        {
                
            $r= Rate::where('product_id',$this->id)->avg('rate');
             if($r){
                return $r;
             }
             return 0;
        }
    


    public function category(){
        return $this->belongsTo(Category::class,'cat_id');
    }


    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'cat_id');
    }

    // public function sizename(){
    //     return $this->hasMany(Size::class,'product_id');
    // }


    public function feature(){
        return $this->hasMany(Features::class,'product_id');
    }


    public function images(){
        return $this->hasMany(Image::class,'product_id');
    }


    public function getUserNameAttribute(){
    
        return \App\User::find($this->attributes["user_id"])->name;
    }

    public function getColorFeaturesAttribute(){
       // return $this->id;
        $c = Features::where('product_id',$this->id)->distinct()->pluck('color')->toArray();
        //return $c;
        $x=[]; 
        $y=[]; 
        $v=[]; 
     

        foreach($c as $value){

           $va = Features::where('color',$value)->where('product_id',$this->id)->get();
           //return $va;
           array_push($y, $va);
           // array_push($x, $value);

         
           $c["color"]= $value;
           $c["sizes"]=$va;
           // return $c[$i];
           array_shift($c);
          
          array_push($x, $c);
          
        }
         // array_shift($x);
         return $x ;
    }


    public function getNameEnAttribute(){
 
         $r = ProductTranslations::query()->where('product_id',$this->id)
         ->where('locale','en')->first();
        // $r = $this::query()->whereTranslation('locale','en')->name;
        return $r['name'];
    }

    public function getNameArAttribute(){
 
         $r = ProductTranslations::query()->where('product_id',$this->id)
         ->where('locale','ar')->first();
        // $r = $this::query()->whereTranslation('locale','en')->name;
        return $r['name'];
    }


    public function getDescriptionEnAttribute(){
 
         $r = ProductTranslations::query()->where('product_id',$this->id)
         ->where('locale','en')->first();
        // $r = $this::query()->whereTranslation('locale','en')->name;
        return $r['description'];
    }


    public function getDescriptionArAttribute(){
 
         $r = ProductTranslations::query()->where('product_id',$this->id)
         ->where('locale','ar')->first();
        // $r = $this::query()->whereTranslation('locale','en')->name;
        return $r['description'];
    }

    public function getPriceMinAttribute(){
 
        $r = Features::query()->where('product_id',$this->id)->min('price');
        return $r;
    }


    public function getOfferPriceAttribute(){
        
        $price = Features::query()->where('product_id',$this->id)->pluck('price')->first();
        $discount = Features::query()->where('product_id',$this->id)->pluck('offer_price')->first();
        if($discount != '' or $discount != null or $discount != 0){
         $discount_p = $price * $discount/100;

         return $price - $discount_p;
     }else{
            return 0;
         }

    }

    


}
