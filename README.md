# Teste Técnico Stautrh

### Passo a passo para a realização dos testes.

  - Realize a importação do arquivo bd_prova.sql para um banco de dados mysql

  - Configure o arquivo \class\connection.php com os dados de acesso do seu banco de dados

  - Importe o arquivo CTESTE STAUTRH.postman_collection.json para seu aplicativo Postman.

  - Utilize o CREATE adicionando os dados desejados para os campos (name, email e password)na aba Body para a criação de um usuário.

  - Utilize o LOGIN adicionando os dados desejados para os campos (email e password) na aba Body para a realização de login de um usuário.

  - Utilize o USER adicionando os dados desejados para o campo (id) na aba Params para a listagem dos dados de um usuário.

  - Utilize o USERS para a listagem dos dados de todos os usuários.

  - Utilize o EDIT adicionando o id do usuário na aba Params e os dados desejados para os campos (name, email e password) na aba Body para a edição de um usuário.

  - Utilize o REMOVE adicionando o id do usuário na aba Params para a remoção de um usuário.

  - Utilize o DRINK adicionando o id do usuário na aba Params e a quantidade de ML para o campo (drink_ml) na aba Body para a inserir quantas vezes o usuário bebeu água e quantas MLs ele consumiu.

  - Utilize o USER HISTORY adicionando os dados desejados para o campo (id) na aba Params para a listagem das datas e quantdade de água em MLs consumidas pelo usuário.

  - Utilize o USER RANKING para a listagem do ranking de usuários que beberam mais água em quantidade de MLs.