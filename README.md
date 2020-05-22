# Instiller Wrapper 

A simple wrapper to handle users/lists using the Instiller API 


## Installation 

`composer require clockworkmarketing/instiller-wrapper`


## Example

```php 
$instiller = new Instiller('API_ID', 'API_KEY');

$user = $instiller->findUser('example@example.com');


// Trigger a workflow (Main method for adding users to a list.)
$workFlowResponse = $instiller->triggerWorkflow(
                        WORKFLOW_API_IDENTIFIER,
                        'example@example.com',
                        $data, # Array
                        $workflow_session_variables # Array
                );

// Find A User 
$user = $instiller->findUser('example@example.com');

// Add a subscriber to a list 
$subscribed = $instiller->subscribeUserToList('example@example.com','LIST_REFERENCE_ID');
```
