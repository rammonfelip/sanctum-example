
## Desafio Projeto Laravel Sanctum

## 1. Instruções
Após fazer o clone do projeto, basta rodar o comando para construir e subir os containers do docker
````
docker-compose up -d --build
````
Após finalizar essa será a configuração das aplicações:

| Serviço | URL              | Descrição                               |
|:--------|:-----------------|:----------------------------------------|
| Laravel | `localhost:8081` | Aplicação Laravel para Cadastro e Login |
| Mailhog | `localhost:8025` | Caixa de Entrada de e-mails             |

## Documentação da API
As rotas de login são acessíveis via API, é gerado o token via Sanctum e precisa ser passado no Header da requisição

#### Cadastro de Usuário

```http
  POST /api/register
```
|Parâmetro |	`Tipo`|	Descrição|
|:-----------| :--------- |:----------------------------------|
|name |	`string`|	Obrigatório. Nome do usuário. Deve ter no máximo 255 caracteres.|
|email |	`string`|	Obrigatório. Email do usuário. Deve ser um email válido, único na tabela users.|
|password |	`string`|	Obrigatório. Senha do usuário. Deve ter no mínimo 8 caracteres e ser confirmada.|
|cep |	`string`|	Obrigatório. CEP do endereço. Deve ter exatamente 8 caracteres.|
|rua |	`string`|	Obrigatório. Nome da rua. Deve ter no máximo 255 caracteres.|
|bairro |	`string`|	Obrigatório. Nome do bairro. Deve ter no máximo 255 caracteres.|
|numero |	`string`|	Opcional. Número do endereço. Deve ter no máximo 10 caracteres.|
|cidade |	`string`|	Obrigatório. Nome da cidade. Deve ter no máximo 255 caracteres.|
|estado |	`string`|	Obrigatório. Sigla do estado. Deve ter exatamente 2 caracteres.|

```json
{
  "name": "João Silva",
  "email": "joao.silva@example.com",
  "password": "senha123",
  "password_confirmation": "senha123",
  "cep": "12345678",
  "rua": "Rua Exemplo",
  "bairro": "Centro",
  "numero": "123",
  "cidade": "São Paulo",
  "estado": "SP"
}

```

#### Login

```http
  POST /api/login
```

| Parâmetro  | Tipo       | Descrição                                 |
|:-----------| :--------- | :---------------------------------------- |
| `email`    | `string` | **Obrigatório** |
| `password` | `string` | **Obrigatório** |

#### Retorna Usuário
Este endpoint retorna os dados do usuário autenticado. O usuário deve estar autenticado e fornecer o token de autenticação no cabeçalho da requisição.
```http request
    GET /api/user
```
Cabeçalhos

| Campo |	Tipo	| Descrição |
|:-----------| :--------- | :--------------------------------------- |
|Authorization |	string	| Obrigatório. Token Bearer gerado no login (Bearer <seu_token_aqui>).|
|Accept |	string	| application/json|

```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao.silva@example.com",
  "created_at": "2023-12-09T12:00:00.000000Z",
  "updated_at": "2023-12-09T12:00:00.000000Z"
}

```

