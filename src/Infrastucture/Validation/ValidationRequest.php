<?php
namespace App\Infrastucture\Validation;

class ValidationRequest
{
	private $definedProperties=[];
	
	private $validatingGroups=["Default"=>true];
	
	public function __construct()
	{
		$this->definedProperties=array_map(function(){return false;},get_object_vars($this));
	}
	
	public function setProperty(string $property,$value)
	{
		if (isset($this->definedProperties[$property]))
		{
			$this->{$property}=$value;
			$this->definedProperties[$property]=true;
		}
	}
	
	public function unsetProperty(string $property)
	{
		if (isset($this->definedProperties[$property]))
		{
			$this->{$property}=null;
			$this->definedProperties[$property]=false;
		}
	}
	
	public function isDefined($property): bool
	{
		return $this->definedProperties[$property]??false;
	}
	
	public function addValidatingGroup($group)
	{
		$this->validatingGroups[$group]=true;
	}
	
	public function removeValidatingGroup($group)
	{
		if (isset($this->validatingGroups[$group]))
		{
			unset($this->validatingGroups[$group]);
		}
	}
	
	public function excludeValidatingGroup($group)
	{
		$this->validatingGroups[$group]=false;
	}
	
	public function getValidatingGroups():array
	{
		return array_keys(array_filter($this->validatingGroups));
	}
	
	public function getDefinedPropertiesValidatingGroups():array
	{
		return array_diff(array_merge(array_keys(array_filter($this->definedProperties)),array_keys(array_filter($this->validatingGroups))),array_keys(array_filter($this->validatingGroups,function($value){return !$value;})));
	}
}