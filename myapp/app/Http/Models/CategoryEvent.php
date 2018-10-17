<?php
/**
 * Category model
 *
 * @author team Yugioh
 */

namespace App\Http\Models;

class CategoryEvent extends \Illuminate\Database\Eloquent\Model
{

	public $table = "category_event";
	protected $fillable = ['category_id', 'event_id'];

}
