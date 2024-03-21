<template>
    <v-container>
        <v-card class="elevation-12" color="grey darken-1">
            <v-card-title class="headline amber--text">
                Bem-vindo!
            </v-card-title>
            <v-img src="/fit-manage-tech.jpg" aspect-ratio="2.75" contain></v-img>
            <v-card-text>
                <p>
                    Olá {{ user . name }},
                </p>
                <p>
                    Seja bem-vindo ao nosso serviço! Estamos muito felizes em tê-lo conosco.
                </p>
                <p>
                    Abaixo estão suas credenciais de acesso:
                </p>
                <ul>
                    <li><strong>Email:</strong> {{ user . email }}</li>
                    <li><strong>Senha:</strong> {{ user . password }}</li>
                </ul>
                <p>
                    Por favor, siga as instruções abaixo para começar a usar nossa plataforma:
                </p>
                <ol>
                    <li>Passo 1: Faça login com suas credenciais.</li>
                    <li>Passo 2: Explore todas as funcionalidades disponíveis.</li>
                    <li>Passo 3: Entre em contato conosco se precisar de ajuda.</li>
                </ol>
                <p>
                    Aproveite sua experiência conosco!
                </p>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .card {
        width: 600px;
        padding: 20px;
    }

    .card-title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .card-text {
        font-size: 16px;
        line-height: 1.6;
    }

    ol {
        margin-top: 10px;
    }

    li {
        margin-bottom: 5px;
    }
</style>
