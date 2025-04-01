Projeto API

Este projeto possui uma API com diversas funcionalidades para manipulação de dados e relacionamentos. Siga as instruções abaixo para configurar, executar e testar a aplicação.
1. Configuração dos Containers

Para iniciar os containers Docker, execute os seguintes comandos:

docker-compose build
docker-compose up -d

2. Criação do Banco de Dados e Pré-registros

Execute o comando abaixo para criar o banco de dados e inserir alguns pré-registros:

docker-compose exec -it app php artisan migrate --seed

Caso prefira reiniciar as migrations:

php artisan migrate:fresh --seed

3. Configuração da Chave JWT

Gere a chave JWT executando:

docker-compose exec -it app php artisan jwt:secret

4. Acesso ao MinIO

Acesse o MinIO pelo navegador na URL: http://localhost:9001

    Usuário: minioadmin

    Senha: minioadmin

Após o login, crie um bucket com o nome: arquivos

5. Testes com Postman

Para testes mais aprofundados, utilize a seguinte coleção do Postman:
Postman Collection

https://www.postman.com/wandrealkimin/wandrealkimin/collection/pl8q2nb/mt

6. Estrutura de Dados

   Foi adicionada uma tabela de estados para melhor normalização dos dados.

   CRUD e PESQUISA estão disponíveis para todas as tabelas.

7. Regras e Endpoints Personalizados
   7.1 Consulta de Servidores Efetivos

Crie um endpoint que permita consultar os servidores efetivos lotados em determinada unidade, parametrizando a consulta pelo atributo unid_id. O retorno deverá conter os seguintes campos:

    Nome

    Idade

    Unidade de lotação

    Fotografia

Endpoint:

/servidores-efetivos?with=todosDados

    O parâmetro with=todosDados garante que todos os relacionamentos especificados sejam retornados.

7.2 Consulta de Endereço Funcional

Crie um endpoint para consultar o endereço funcional (da unidade onde o servidor é lotado) a partir de uma parte do nome do servidor efetivo.

Endpoint:

/servidores-efetivos-search?with=todosDados&user_nome=Mendonça

    No parâmetro with, deve-se passar o nome do relacionamento. Para pesquisar dentro do relacionamento, utilize o seguinte formato:
    relacionamento_nomecampo

7.3 Relacionamentos Muitos-para-Muitos

Para salvar um relacionamento do tipo muitos-para-muitos, envie o campo com o prefixo id_ seguido do nome do relacionamento no método POST/PUT.

Exemplo na URL /unidades:

{
"nome": "dada",
"sigla": "U02",
"id_enderecos": 1
}

7.4 Dinamismo nos CRUDs

Foi criada uma Trait no controller para garantir que todo o CRUD e as pesquisas sejam dinâmicos, facilitando a manutenção e expansão da API.
