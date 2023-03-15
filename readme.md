# Commission Calculator

This project calculates commission fees based on transaction data.

## Requirements

- PHP 7.4 or higher
- Composer

## Installation

1. Clone the repository:

git clone https://github.com/yourusername/commission-calculator.git

2. Change to the project directory:
cd commission-calculator
3. Install dependencies using Composer:
composer install
4. Copy `.env.example` to `.env` and update the environment variables according to your API credentials:
cp .env.example .env

## Usage

To calculate commission fees, provide a text file with transaction data as input. Each line in the file should represent a JSON object with the following properties:

- `bin`: The Bank Identification Number of the transaction.
- `amount`: The transaction amount.
- `currency`: The currency code of the transaction.

Example input file (`input.txt`):

{"bin":"45717360","amount":"100.00","currency":"EUR"}
{"bin":"516793","amount":"50.00","currency":"USD"}
{"bin":"45417360","amount":"10000.00","currency":"JPY"}
{"bin":"41417360","amount":"130.00","currency":"USD"}
{"bin":"4745030","amount":"2000.00","currency":"GBP"}
To calculate commission fees based on the input file, run the following command:
php index.php input.txt
The output will display the commission fees for each transaction, one per line:
1.00
0.8
0.77
2.08
44.45

## Tests

To run unit tests, execute the following command in the project directory:

./vendor/bin/phpunit










