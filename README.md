# Plurish UI

## Como rodar local

0. Clonar repositório
```bash
git clone https://github.com/plurish/ui.git ~/dev/plurish/ui

cd ~/dev/plurish/ui
```

1. Subir containeres e debuggar

Para subir os containers, uma opção é o uso direto do Docker Compose:
```bash
docker compose up --build
```

Outra alternativa, é usar a seção de 'Run and Debug' do VS Code.
Com ela, é possível subir os containers e, caso queira, debuggar a execução
do código, bastando apenas definir os breakpoints.


## Libraries de terceiros

Após a instalação das libraries com composer/yarn (ou após subir os containers), é necessário
copiar manualmente os arquivos da `node_modules` e da `vendor`, que estão no container,
para dentro da sua própria máquina, de modo que o VS Code reconheça a existência das libraries instaladas,
sem mostrar erros:

```bash
sudo docker cp plurish-ui:/var/www/vendor ~/dev/plurish/ui
sudo docker cp plurish-ui:/var/www/node_modules ~/dev/plurish/ui
```