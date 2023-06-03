# Desafio Onfly

Projeto separado em front e back-end

# Tecnologias utilizadas:<br/>

Front-end: React + TypeScript + Vite <br/>
Back-end: Laravel como API

# Como rodar o projeto?

Ao clonar o projeto, abra 2 terminais:<br/>
Um terminal dentro da pasta front-end, e nesse digite npm install (para instalar as dependências)<br/>
E em seguida digite num run dev ou quasar dev para executar o projeto.<br/>
Caso seu terminal não reconheça o comando npm, instale o node versão 18^ no seu PC https://nodejs.org/en<br/>
_OBS_: O terminal não deve ser utilizando PowerShell.
<br/><br/>
Já o segundo terminal deve estar dentro da pasta back-end, deve-se rodar composer install<br/>
Crie um banco de dados vazio e insira as informações de acesso no arquivo .env<br/>
Rode o seguinte comando no terminal: php artisan migrate<br/>
E em seguida: php artisan serve<br/>
_OBS_: Caso seu computador não reconheça o comando composer, faça o download pelo passo a passo a seguir: https://getcomposer.org/download/<br/>
E caso você não tenha o php instalado, você pode instalar o xampp pelo seguinte link: https://www.apachefriends.org/pt_br/download.html (sugestão mais fácil para testes)

# Como testar?

Leia primeiro a documentação do postman, depois a documentação da API. <br />
Sugiro utilizar o postman (plataforma que eu utilizei e disponibilizei na pasta raiz do projeto a collection com as requisições para teste) https://www.postman.com/downloads/ <br />
Documentação do POSTMAN: https://docs.google.com/document/d/11ZH0ph80WBkZoxG18MP6nho4eEYnFgXvLsJt2_ceaTM/edit?usp=sharing <br/>
Documentação da API: https://docs.google.com/document/d/1hxwiJBvP8HfRFmXAxNPVPtaFosOPnEvIWkF1mbKZN3E/edit?usp=sharing

# Regras de negócio

Back-end:<br />

- Utilizei policies e form requests para validar a aplicação back-end, portanto as rotas que fazem modificações nas despesas não serão encontradas caso o usuário não esteja autenticado (tutorial postman documentação acima ^). <br />
- O usuário logado pode criar despesas sem problema algum e visualizar todas as despesas, porém só pode atualizar e deletar as próprias despesas, portanto um usuário de id 1 não pode apagar ou atualizar despesas do usuário id 2. <br /><br />

Front-end: <br />

- O CRUD é aberto, não tem policies de restrição, portanto você deve fazer seu cadastro e login. <br />
- No formulário de registro inicial, você pode selecionar se o seu usuário é admin ou não (fiz um plus para o desafio login + validação se é admin). <br />
- Usuários administradores podem apagar qualquer tipo de usuário. (Tomei o cuidado de se você apagar ou alterar seu próprio usuário, você automaticamente será deslogado)
- Usuários comuns podem visualizar e editar qualquer usuário (Para mostrar a funcionalidade em prática, deixei de propósito a edição aberta para qualquer usuário).
