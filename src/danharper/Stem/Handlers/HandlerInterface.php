<?php namespace danharper\Stem\Handlers;

interface HandlerInterface
{
	public function register();
	public function run($modifier = null);
}