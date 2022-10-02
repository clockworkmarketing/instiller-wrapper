# Instiller Wrapper 

A simple wrapper to handle users/lists using the Instiller API 


## Installation 

`composer require clockworkmarketing/instiller-wrapper`

## API Keys

The first step to getting started with the API is to generate API keys. Admin rights are required to perform this action within the [account settings screen](https://app.emailmarketingbrilliance.co.uk/help/account_settings). Once API keys have been generated, HTTP GET and POST requests can be made to all API endpoints.

## Documentation 

The API Documentation can be found [here](https://app.emailmarketingbrilliance.co.uk/help/api_integration).



## Example

```php 
$instiller = new Instiller('API_ID', 'API_KEY');

$user = $instiller->findUser('example@example.com');

$status = $instiller->getAccountStatus(); 
echo $status->transactions_balance; // 10000

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
