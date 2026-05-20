# Multicaixa Express

Nome: Júlio Paulo Altino Luwungu
Número: 12
Turma: II12B

O Multicaixa Express é uma aplicação web desenvolvida em PHP, inspirada em aplicativos bancários modernos e carteiras digitais. O sistema permite que usuários realizem operações financeiras básicas de forma simples, rápida e intuitiva, enquanto administradores possuem controle total sobre o gerenciamento das contas e saldos.

A aplicação foi criada com foco em:

experiência de usuário moderna;
interface responsiva;
segurança básica de autenticação;
organização profissional do código;
funcionamento automático do banco de dados.
Funcionalidades Principais
Usuários Comuns

Os usuários cadastrados podem:

Criar conta
Fazer login seguro
Consultar saldo
Transferir dinheiro entre usuários
Levantar dinheiro
Pagar serviços
Visualizar extrato de transações
Encerrar sessão
Sistema de Pagamentos

O sistema possui pagamentos simulados para serviços reais, incluindo:

Energia
ENDE
PRODEL
RNT
Internet
Unitel
Africell
Movicel
Água
EPAL
Água Pura
Hidrochicapa
TV
Zap
DSTV
TV Cabo

Cada empresa possui referências válidas específicas, garantindo uma experiência semelhante a aplicativos bancários reais.

Painel Administrativo

O sistema possui uma área administrativa exclusiva para administradores.

O administrador pode:

Visualizar todos os usuários
Consultar saldos
Depositar dinheiro em contas
Eliminar contas de usuários
Visualizar movimentos financeiros
Monitorar estatísticas do sistema
Super Admin Automático

Ao executar o projeto pela primeira vez, o sistema cria automaticamente uma conta de super administrador.

Credenciais padrão
Email: admin@gmail.com
Senha: Ha2rd0wa0re7

O super admin possui acesso completo ao painel administrativo.

Tecnologias Utilizadas
PHP
MySQL
HTML5
CSS3
JavaScript
PDO (PHP Data Objects)
Banco de Dados Automático

O projeto foi desenvolvido para criar automaticamente:

banco de dados;
tabelas;
estrutura inicial;
conta super admin.

Isso significa que o usuário não precisa criar manualmente o banco de dados para começar a usar o sistema.

Estrutura do Projeto
multicaixa-express/
│
├── actions/
├── api/
├── classes/
├── config/
├── database/
├── includes/
├── public/
│
└── README.md
Segurança Implementada

O sistema possui:

autenticação com sessões;
hash de senhas com password_hash();
proteção de rotas administrativas;
separação entre login administrativo e login comum;
validação de saldo;
validação de referências de pagamento.
Interface

A interface foi inspirada em aplicativos bancários modernos como o Multicaixa Express, utilizando:

tema escuro;
design responsivo;
cores principais:
branco;
#FEA734 (amarelo alaranjado).

Como Executar o Projeto:
1. Clonar o projeto
git clone <https://github.com/julioluwungu/multicaixa-express>
2. Mover para o XAMPP

Coloque a pasta do projeto dentro de:

htdocs/
3. Iniciar serviços

Inicie:

Apache
MySQL

no painel do XAMPP.

4. Abrir no navegador
http://localhost/multicaixa-express/public
Objetivo do Projeto

Este projeto foi desenvolvido com fins:

educacionais;
acadêmicos;
prática de desenvolvimento web;
simulação de sistemas bancários digitais.
Melhorias Futuras

Algumas melhorias planejadas incluem:

PIN de transações
QR Code para pagamentos
Upload de foto de perfil
Notificações em tempo real
Comprovantes PDF
Modo claro/escuro
Estatísticas financeiras avançadas
