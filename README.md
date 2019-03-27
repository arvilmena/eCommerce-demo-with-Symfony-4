# Ecommerce system using Symfony 4

This is a simple phone shop built on Symfony 4. The shop was inspired by the [app made by CodingAddict __(React Tutorial: Build an e-commerce site from scratch using React and Netlify)__](https://www.youtube.com/watch?v=wPQ1-33teR4), but this is system was completely built with PHP and Bootstrap 4.

## Setting up

1. ```git clone https://github.com/arvilmena/eCommerce-demo-with-Symfony-4```
2. ```cd eCommerce-demo-with-Symfony-4```
3. ```composer install```
4. ```cp .env .env.local```
5. Update `DATABASE_URL`, `PAYPAL_MERCHANT_USERNAME`, `PAYPAL_MERCHANT_PASSWORD`, `PAYPAL_MERCHANT_SIGNATURE` variables
6. ```./bin/console doctrine:database:create```
7. ```./bin/console doctrine:migrations:migrate```
8. ```./bin/console doctrine:fixtures:load```
9. ```yarn```
10. ```yarn encore production```
11. ```./bin/console server:run```
12. Navigate to your [http://localhost:8000](http://localhost:8000)

# Screens

![Homepage](/docs/images/home.png)
The homepage
