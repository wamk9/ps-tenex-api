Projeto criado para participação no processo seletivo da Tenex.

Basicamente aqui podemos criar e visualizar carnês com suas devidas parcelas, como framework foi utilizado o Laravel para facilitar e acelerar essa criação.

## Como realizar o teste da API

Para realizar o teste devemos primeiramente ter o PHP e MySQL instalado no ambiente, com isso poderemos prosseguir com a execução do "artisan" do Laravel.

Rode os comandos abaixo na pasta onde o projeto se encontrará, utilizando o terminal:

```
php migrate
php artisan serve
```

Após, valide o endereço que encontra-se no terminal e acesse a API via Postman/Insomnia utilizando as seguintes rotas:

- POST - http://{Endereço:Porta}/api/paymentbooklet/ - Criação do carnê, aqui temos os seguintes campos:
    valor_total (float): O valor total do carnê.
    qtd_parcelas (int): A quantidade de parcelas.
    data_primeiro_vencimento (string, formato YYYY-MM-DD): A data do primeiro vencimento.
    periodicidade (string, valores possíveis: "mensal", "semanal"): A periodicidade das parcelas.
    valor_entrada (float, opcional): O valor da entrada.

- GET - http://{Endereço:Porta}/api/paymentbooklet/{id} - Aqui teremos a rota para a visualização das informações do carnê, para acessar essas informações basta inserir o ID do respectivo carnê que mostrará todas as informações
