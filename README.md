<p align="center"><a href="https://idez.com.br/" target="_blank"><img src="./storage/images/thumbnail.png" width="100%" alt="Idez"></a></p>

## City Finder

O projeto lista todas as cidades dentro de um estado brasileiro

## Como rodar o projeto?

### 1. Sail

É altamente recomendado que você tenhas as ferramentas `docker` e `docker-compose` para executar o projeto, assim é possível utilizar a ferramenta [Sail](https://laravel.com/docs/10.x/sail#introduction) (que nada mais é do que um arquivo `docker-compose.yml` e um script `sail` que é armazenado na raiz do projeto) do próprio Laravel.

O comando Sail nos disponibiliza uma CLI com diversos métodos convenientes pra interagir com os contêiners Docker definidos pelo arquivo `docker-compose.yml`, além de prover um acesso fácil ao `artisan`, `composer` e muito mais! O Sail atualmente está disponível para as plataformas macOS, Linux e Windows (através do WSL2).

A instalação para cada sistema operacional varia, portanto abaixo está um link da própria documentação do Laravel com mais instruções para a instalação das dependências do projeto.

https://laravel.com/docs/10.x/installation#docker-installation-using-sail

### 2. Via Composer (Não recomendado)

(Ainda) Não foram realizadas tratativas de CORS para as requisções, logo, muito provavelmente ocasionará em erros caso rode o projeto via composer.

Pré-requisitos:

- Certifique-se de ter o PHP na versão 8 ou mais recente instalado em sua máquina.
- Instale o [Composer](https://getcomposer.org/download/)

No terminal, navegue para o diretório do projeto e digite:

```bash
php artisan serve
```

## Endpoints disponíveis

O projeto conta com três endpoints:

> Caso for rodar o projeto através do Laravel Sail, O valor de `$baseUrl` provavelmente será http://localhost:80/api

> `$state` deve ser a `sigla` do Estado, não o nome.
> `$page` deve ser um inteiro que simboliza a página atual, o query parameter `page` é opcional.

- `{$baseUrl}`/v1/cities/`{$state}`?page=`{$page}`
- `{$baseUrl}`/v1/states (primariamente para fins de testes)
- `{$baseUrl}`/documentation

## Deployment

Realizei o deployment da aplicação na plataforma [Railway](https://railway.app/) e você pode acessar através do link abaixo

https://cityfinder-production.up.railway.app/api/v1/cities/mg?page=1

Devido a algumas limitações da plataforma, não é possível acessar o endpoint de documentação.
