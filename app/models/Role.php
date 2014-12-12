<?php
	
class Role extends \Eloquent 
{	
	// Add your validation rules here
			
	public static $rules = array(        
		'role' => 'required|alpha|min:2|max:200|unique:roles,role'    
	);	
	
	// Don't forget to fill this array	
	protected $fillable = ['role'];    
	
	public function users()    
	{        
		return $this->belongsToMany('User');    
	}
}