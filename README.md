# Instiller Wrapper 

A simple wrapper to handle users/lists using the Instiller API 


## Installation 

`composer require clockworkmarketing/instiller-wrapper`


## Example

```php 
$instiller = new Instiller('API_ID', 'API_KEY');

$user = $instiller->findUser('example@example.com');

$subscribed = $instiller->subscribeUserToList('example@example.com','LIST_REFERENCE_ID');
```

More Docs Soon. 
