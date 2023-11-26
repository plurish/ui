const username = [
    (username: string) =>
        username?.length >= 2 || 'O username deve ter ao menos 2 caracteres',
];

const email = [
    (email: string) =>
        /.+@.+\..+/.test(email) || 'Digite um e-mail válido (a@a.com)',
];

const password = [
    (password: string) =>
        password?.length >= 4 || 'A senha deve ter ao menos 4 caracteres',
];

const validations = {
    username,
    email,
    password,
};

export default validations;
