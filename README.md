# Projeto para cadastro e cálculo de impostos

## Requisitos mínimos:
- PHP versão 7.4.0 
- Node.js versão 10.16.3
- Npm versão 6.9.0 
- Banco de dados Mysql/MariaDb
## Instruções de uso:

- Faça o clone do repositório;
- Importe para seu bando de dados o arquivo `impostodb.sql` localizado na raiz do projeto;
- Abra o seu terminal na raiz do projeto e execute a sequência de comandos a seguir:
```sh
$ npm install

$ npm run dev

$ php artisan serve
```
# Acesso a aplicação
- **[Web](http://127.0.0.1:8000/impostos)**
- **[API](http://127.0.0.1:8000/api/imposto)**

# Consumo das API's

## Listar impostos
Método: GET

Retorno:
```json
{
  "data": [
    {
      "id": 1,
      "uf": "AC",
      "percentual": "1.25",
      "produto_id": 1
    },
    ...
  ],
  "message": "Sucesso!!"
}
```

## Cadastrar Imposto
Método: POST

Requisição:
```json
{
	"uf":"DF",
	"percentual":35,
	"produto_id": 1
}
```
Retorno: 
```json
{
  "data": {
    "uf": "DF",
    "produto_id": 1,
    "percentual": 35,
    "id": 18
  },
  "message": "Sucesso!"
}
```

## Excluir Imposto
Método: DELETE

URL : http://127.0.0.1:8000/api/imposto/{idImposto}

Retorno: 
```json
{
  "data": [],
  "message": "Imposto deletado com sucesso!!"
}
```

## Simular valor de imposto
Método: PUT

Requisição:
```json
{
	"uf":"DF",
	"preco": 200,
	"produto_id": 1

}
```
Retorno: 
```json
{
  "data": {
    "uf": "DF",
    "produto_id": 1,
    "preco": 200,
    "valor_imposto": 70
  },
  "message": "Sucesso!"
}
```
