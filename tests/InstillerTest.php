<?php

use ClockworkMarketing\InstillerWrapper\Instiller;
use ClockworkMarketing\InstillerWrapper\Request;

test('it can get account status ', function () {
     $mock = mock(Instiller::class)->shouldReceive('getAccountStatus')
         ->andReturn((object)[
             'company_name' => 'Some Company',
             'api_identifier' => 'some_company',
             'transactions_limited' => true,
             'transactions_balance' => 10000],)
         ->getMock();

     expect($mock->getAccountStatus())->toHaveProperty('company_name')
         ->and($mock->getAccountStatus()->company_name)->toBe('Some Company');

});

test('it can get valid user details', function() {
    $mock = mock(Instiller::class)->shouldReceive('findUser')
        ->andReturn((object)[
            'title' => 'Mr',
            'first_name' => 'B',
            'last_name' => 'Lobby'
        ])->getMock();

    expect($mock->findUser('valid@email.com.com')->last_name)->toBe('Lobby');
});

test('it gets null when user not found', function() {
    $mock = mock(Instiller::class)->shouldReceive('findUser')
        ->andReturn(null)->getMock();

    expect($mock->findUser('valid@email.com.com'))->toBeNull();

});
