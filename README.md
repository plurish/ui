# Plurish UI

## Recomendações
1. Clonar projeto para dentro de diretório `~/dev/plurish/ui`

Caso esteja num Linux (ou WSL):
```bash
git clone https://github.com/plurish/ui.git ~/dev/plurish/ui
```

2. Usar o seguinte docker-compose.yml, para desenvolvimento local:

```yml
version: '3.8'

services:
  ui:
    container_name: plurish-ui
    image: plurish/ui:dev
    build:
      context: ./ui
      dockerfile: Dockerfile
    restart: unless-stopped
    ports:
      - 8000:8000
    volumes:
      - ./ui:/var/www

  db:
    image: mysql:8.1
    container_name: plurish-db-user
    restart: always
    environment:
      MYSQL_ROOT_USER: root
      MYSQL_ROOT_PASSWORD: root
    volumes:
      - db-user:/var/lib/mysql
    ports:
      - 3306:3306

volumes:
  db-user:
    name: plurish-db-user
```

A estrutura de pastas ficaria mais ou menos assim:
```
- ~/dev/
    - plurish/
        - ui/
        - docker-compose.yml
```
Desse modo, seria possível executar o docker-compose.yml para rodar múltiplos
projetos do plurish ao mesmo tempo, cada um em seu container

## Como rodar local
O recomendado é o uso da docker-compose.yml file acima,
pois facilita o levantamento dos containers de modo mais fácil:

```bash
docker compose up
```

Mas caso queira rodar o UI individualmente, execute o `docker run` de dentro
do diretório do projeto:
```bash
# deixa a UI rodando na porta 8000
docker run --name=plurish-ui -p 8000:8000 plurish/ui:dev
```