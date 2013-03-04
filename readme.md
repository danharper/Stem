# Stem

A simple fixtures library for PHP.

[![Build Status](https://travis-ci.org/danharper/Stem.png?branch=master)](https://travis-ci.org/danharper/Stem)

## Example

Declare what a fixture should look like:

```php
<?php
Stem::fixture('User', array(
	'id' => ':int'
	'name' => '2:words',
	'email' => ':email',
	'bio' => ':string',
));
```

Then use it:

```php
<?php
$fixture = Stem::attributes('User');

// array(
//   'id' => 29,
//   'name' => 'foo banana',
//   'email' => 'mascot28384@bread.example.com',
//   'bio' => 'dawn chat grandpa ballplayer cell Jill wing brainstorm chill Jills hunk ache'
// )
```

Or even create a real object directly from it:

```php
<?php
$obj = Stem::make('User');

// this calls:
// new User(array( ... ))
```

In simpler cases you may just need a couple of random words:

```php
<?php
Stem::run('3:words');
```

## Provided Handlers

* `:string` and `:words` -- prefix with a number for that many words, eg. `3:words`
* `:word` -- for a single word, for clarity in your code you could even write `1:word` (`1:words` would also work)
* `:int` and `:number` -- prefix with a number for a number from 0 _up to_ the given number
* `:email`

## Registering your own Handlers

With a class:
Provide `Stem::register()` with an object which when told `register` returns what it wishes to be known as, and when told `run` with an optional modifier returns something to display. Implent `danharper\Stem\Handlers\HandlerInterface` for clarity.

```php
<?php

class CustomHandler {
	public function register() {
		return 'custom';
	}

	public function run($modifier) {
		if ($modifier)
			return "something $modifier";
		else
			return "something else";
	}
}

Stem::register(new CustomHandler);

Stem::run('lorem:custom'); // something lorem
Stem::run(':custom'); // something else
```

With a closure:
Or provide `Stem::register()` with a Closure behaving as the run method in the class above, and with the second argument what it wishes to be known as.

```php
<?php

Stem::register(function($modifier) {
	if ($modifier)
		return "something $modifier";
	else
		return "something else";
}, 'foobar');

Stem::run('baz:foobar'); // something baz
Stem::run(':foobar'); // something else
```

