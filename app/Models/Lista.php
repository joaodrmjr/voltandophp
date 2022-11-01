<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model {

	protected $table = "lista";

	protected $fillable = [
		"name",
		"last_name"
	];
}