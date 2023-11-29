<p align="center"><a href="https://idez.com.br/" target="_blank"><img src="./storage/images/thumbnail.png" width="400" alt="Idez"></a></p>

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

> Caso for rodar o projeto localmente, O valor de `$baseUrl` provavelmente será http://localhost:80/api

> `$state` deve ser a `sigla` do Estado, não o nome.
> `$page` deve ser um inteiro que simboliza a página atual, o query parameter `page` é opcional.

- `{$baseUrl}`/v1/cities/`{$state}`?page=`{$page}`
- `{$baseUrl}`/v1/states (primariamente para fins de testes)
- `{$baseUrl}`/documentation

## Checklist

- [x] Criar rota para pesquisar e listar municípios de uma UF
- [x] Resposta da requisição deve conter uma lista de municípios com os seguintes campos:
  - [x] name ⇒ nome do município
  - [x] ibge_code ⇒ código IBGE deste município
- [x] Deve ser utilizada como providers as seguintes APIs:
  - IBGE - [https://servicodados.ibge.gov.br/api/v1/localidades/estados/rs/municipios](https://servicodados.ibge.gov.br/api/v1/localidades/estados/rs/municipios)
  - Brasil API - [https://brasilapi.com.br/api/ibge/municipios/v1/RS](https://brasilapi.com.br/api/ibge/municipios/v1/RS)
- [x] O provider usado deve ser definido via variável de ambiente
- [x] Deve conter testes
  - [ ] unitários
  - [x] integração (poucos, mas melhor do que nada)

**Bônus**:

- [x] Uso de cache
- [x] Tratamento de excessões (após finalizar o projeto percebi que algumas tratativas eram falhas)
- [x] Documentação do projeto
- [ ] Github Actions.
- [x] Commits atômicos e descritivos.
- [x] Paginação dos resultados.
- [ ] Criação de SPA consumindo o endpoint criado
- [ ] Disponibilização do projeto em algum ambiente cloud.
- [x] Conteinerização
