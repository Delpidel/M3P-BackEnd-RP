## Setup Local (Manual)

Para garantir a execução correta da API no ambiente local, siga as etapas:

### Crie o banco de dados usando docker

```bash
docker run --name academia -e POSTGRESQL_USERNAME=admin -e POSTGRESQL_PASSWORD=admin -e POSTGRESQL_DATABASE=academia_api -p 5432:5432 bitnami/postgresql
```

#### Conecte com o dbeaver para visualizar os dados - opcional

No DBeaver, vá para "Nova Conexão", escolha "PostgreSQL", avance para a próxima aba e insira as credenciais conforme definido no comando de criação do banco de dados. Teste a conexão e conclua o processo.

##

### Clone o projeto

```bash
cd "caminho/da/sua/pasta"
git clone https://github.com/DEVinHouse-Zucchetti/M3P-BackEnd
cd "M3P-BackEnd"
code ./ #Abrirá o Vscode na raiz do projeto
```

### Instale as dependências do projeto

```bash
composer install
```

##

### Configure o ambiente

Na raiz do projeto, localize o arquivo .env.example, duplique-o e altere seu nome para .env, inicialmente, nenhuma outra alteração é necessária.

### Execute o comando para criar as migrações do banco de dados

```sh
php artisan migrate
```

### Execute a seed para popular o banco de dados

```sh
php artisan db:seed
```

### Execute o comando para criação da APP KEY

```sh
php artisan key:generate
```

### Inicialize o servidor

```sh
php artisan serve
```

## Setup Docker (virtualização do ambiente)

### Clone o projeto

```bash
cd "caminho/da/sua/pasta"
git clone https://github.com/DEVinHouse-Zucchetti/M3P-BackEnd
cd "M3P-BackEnd"
code ./ #Abrirá o Vscode na raiz do projeto
```

### Configure o ambiente

Primeiro, é necessário construir as imagens e criar o banco de dados:

```sh
docker compose up -d --build
```

Em seguida, execute o setup, que inclui a instalação de dependências, criação do arquivo .env, geração da APP KEY, execução das migrações e das seeds:

```sh
docker compose exec php composer setup
```

### Inicialize o servidor

Neste projeto, foi configurado o seguinte comando para facilitar a inicialização:

```sh
composer serve
```

## Executando os Testes Unitários

Para executar os testes, é necessário habilitar o SQLite em memória e executar o comando. Todas as configurações já estão feitas, incluindo o X-debug.

### Habilitação para utilização de sqlite em memoria

No arquivo phpunit.xml, habilite as seguintes linhas:

```xml
<env name="DB_CONNECTION" value="sqlite" />
<env name="DB_DATABASE" value=":memory:" />
```

### Execute o comando para rodar os testes

```bash
docker compose exec php php artisan test --coverage
```

##

### Comandos para migrações

Para executar uma nova migração:

```bash
composer migrate
```

Para reverter:

```bash
composer rollback
```

##

### Acessando o bash

Os comandos com composer foram configurados, isto é, são atalhos de comandos maiores. Porém, outro modo de se trabalhar seria acessando o terminal da maquina virtual:

```bash
docker compose exec php bash
```

Aparecerá algo como "root@docker-desktop:/var/www# ", dentro desse terminal você poderá rodar todos os comandos que estamos habituados.

##

### Finalizei o dia, como encerrar a virtualização

Basta encerrar o servidor com ctrl+c e clicar em stop no container (m3p-backend) do docker desktop. Isso garante o encerramento do processo e garante que não continue em execução em segundo plano.

### Iniciei o dia, como iniciar a virtualização

Se você já fez todo o setup, basta clicar em start no container m3p-backend do docker desktop e rodar o servidor com composer serve.

##

### Desativação da Virtualização

Para desativar completamente a virtualização, rode o comando:

```sh
docker compose down
```

Atenção, se esse comando for executado, será necessário refazer todo o processo de configuração pois tudo será apagado.
