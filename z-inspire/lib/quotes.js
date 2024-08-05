import inquirer from 'inquirer';

export const quotes = {
    Sad: "Keep your face to the sunshine and you cannot see a shadow. - Helen Keller",
    Happy: "The purpose of our lives is to be happy. - Dalai Lama",
    Elated: "The only limit to our realization of tomorrow is our doubts of today. - Franklin D. Roosevelt",
    Angry: "For every minute you are angry you lose sixty seconds of happiness. - Ralph Waldo Emerson",
    Anxious: "Do not anticipate trouble, or worry about what may never happen. Keep in the sunlight. - Benjamin Franklin",
};

const questions = [
    {
        type: 'list',
        name: 'mood',
        message: 'How are you feeling?',
        choices: Object.keys(quotes),
    },
];

export const promptUser = () => {
    inquirer.prompt(questions).then(answers => {
        console.log(`\n${quotes[answers.mood]}\n`);
    });
};
