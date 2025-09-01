<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="img/icone.png">
<title>ConectaSys - CRM para Consórcios</title>
<meta name="description" content="CRM inteligente para vendas de consórcios com captação automática de leads, gestão de equipe e cálculo automático de comissões.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #6366f1;
    --secondary: #4338ca;
    --background: #f9fafb;
    --text: #111827;
    --white: #ffffff;
    --accent: #22c55e;
    --shadow: rgba(0,0,0,0.07);
}
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: var(--background);
    color: var(--text);
}
header {
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    color: var(--white);
    text-align: center;
    padding: 80px 20px 40px;
}
header h1 {
    font-size: 3rem;
    font-weight: 700;
}
header p {
    font-size: 1.2rem;
    max-width: 600px;
    margin: 10px auto 0;
}
section {
    max-width: 1100px;
    margin: 50px auto;
    padding: 0 20px;
}
section h2 {
    text-align: center;
    color: var(--primary);
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 25px;
}
ul {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 15px;
    padding: 0;
    list-style: none;
    max-width: 900px;
    margin: 0 auto;
}
ul li {
    background: var(--white);
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 6px 16px var(--shadow);
    display: flex;
    align-items: center;
    font-size: 1rem;
    transition: transform 0.3s;
}
ul li:hover {
    transform: translateY(-4px);
}
ul li::before {
    content: '✔';
    color: var(--accent);
    margin-right: 10px;
}
.planos {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    margin-top: 30px;
}
.plano {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 8px 20px var(--shadow);
    padding: 30px 20px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    border: 2px solid transparent;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.plano:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px var(--shadow);
    border-color: var(--primary);
}
.plano h3 {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--secondary);
    margin: 10px 0;
}
.plano .preco {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary);
    background: rgba(99, 102, 241, 0.08);
    padding: 8px 0;
    border-radius: 8px;
    margin: 12px 0 4px;
    white-space: nowrap;
}
.plano .preco-anual {
    font-size: 0.95rem;
    font-weight: 500;
    color: #374151;
}
.plano .preco-anual .economize {
    color: var(--accent);
    font-weight: 600;
}
.plano p.check {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    gap: 8px;
    min-height: 32px;
    margin: 6px 0;
}
.plano p.check svg {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    color: var(--accent);
}
.cta-button {
    background: var(--accent);
    color: var(--white);
    padding: 12px 24px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    margin-top: 15px;
    transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
}
.cta-button:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(22, 163, 74, 0.3);
}
footer {
    background: var(--secondary);
    color: var(--white);
    text-align: center;
    padding: 20px;
    font-size: 0.95rem;
}
footer a {
    color: #c7d2fe;
    text-decoration: none;
    margin: 0 8px;
}
footer a:hover {
    text-decoration: underline;
}
@media (max-width: 600px) {
    header h1 {
        font-size: 2rem;
    }
    header p {
        font-size: 1rem;
    }
}
</style>
</head>
<body>
<header>
<h1>ConectaSys</h1>
<p>Organize suas vendas de consórcios com captação automática de leads, gestão de equipe e cálculo automático de comissões em um só lugar.</p>
</header>

<section>
<h2>Por que usar o ConectaSys?</h2>
<ul>
    <li>Captação automática de leads do Facebook</li>
    <li>Gestão de leads</li>
    <li>Cadastro e acompanhamento de vendedores</li>
    <li>Cálculo automático de comissões</li>
    <li>Relatórios e KPIs para monitoramento</li>
    <li>Funil de vendas visual e fácil de usar</li>
    <li>Economia de tempo com automação de processos</li>
    <li>Interface simples e intuitiva</li>
</ul>
</section>

<section>
    <h2>Planos e Preços</h2>
    <div class="planos">
        <div class="plano">
            <h3>Plano Individual</h3>
            <p class="preco">R$ 60,00/mês</p>
            <p class="preco-anual">ou R$ 612,00/ano (<span class="economize">economize 15%</span>)</p>
            <p class="check">
                ✔ 1 usuário
            </p>
            <p class="check">
                ✔ Todas as funcionalidades
            </p>
            <p class="check">
                ✔ Suporte via WhatsApp
            </p>
           <a href="#" class="cta-button" data-plano="Plano Individual">Assinar</a>
        </div>
    
        <div class="plano">
            <h3>Plano Inicial</h3>
            <p class="preco">R$ 150,00/mês</p>
            <p class="preco-anual">ou R$ 1.530,00/ano (<span class="economize">economize 15%</span>)</p>
            <p class="check">
                ✔ 1 usuário gerente
            </p>
            <p class="check">
                ✔ Até 3 usuários normais
            </p>
            <p class="check">
                ✔ Suporte via WhatsApp
            </p>
            <a href="#" class="cta-button" data-plano="Plano Inicial">Assinar</a>
        </div>
    
        <div class="plano">
            <h3>Plano Equipe</h3>
            <p class="preco">R$ 300,00/mês</p>
            <p class="preco-anual">ou R$ 3.060,00/ano (<span class="economize">economize 15%</span>)</p>
            <p class="check">
                ✔ 2 usuários gerentes
            </p>
            <p class="check">
                ✔ Até 8 usuários normais
            </p>
            <p class="check">
                ✔ Suporte via WhatsApp
            </p>
           <a href="#" class="cta-button" data-plano="Plano Equipe">Assinar</a>
        </div>
    
        <div class="plano">
            <h3>Plano Empresarial</h3>
            <p class="preco">R$ 400,00/mês</p>
            <p class="preco-anual">ou R$ 4.080,00/ano (<span class="economize">economize 15%</span>)</p>
            <p class="check">
                ✔ usuários ilimitados
            </p>
            <p class="check">
                ✔ Todas as funcionalidades
            </p>
            <p class="check">
                ✔ Suporte via WhatsApp
            </p>
            <a href="#" class="cta-button" data-plano="Plano Empresarial">Assinar</a>
        </div>
    </div>
    <p style="text-align:center; margin-top: 20px;">Assine o plano anual e economize 15% no ConectaSys!</p>
</section>

<script>
    document.querySelectorAll('.cta-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
    
            const plano = this.getAttribute('data-plano');
            const numeroWhatsapp = '5549998098805'; // coloque seu número no formato DDI+DDD+Número
            const mensagem = encodeURIComponent(`Olá, gostaria de assinar o plano ${plano} do ConectaSys.`);
    
            const url = `https://wa.me/${numeroWhatsapp}?text=${mensagem}`;
            window.open(url, '_blank');
        });
    });
</script>

<footer>
<a href="#">Política de Privacidade</a> • <a href="#">Termos de Uso</a>
<p>ConectaSys © 2025</p>
</footer>
</body>
</html>
