import { expect } from 'chai';
import { quotes } from '../lib/quotes.js';

describe('Quotes Object', () => {
    it('should have a quote for Sad', () => {
        expect(quotes).to.have.property('Sad');
    });

    it('should have a quote for Happy', () => {
        expect(quotes).to.have.property('Happy');
    });

    it('should have a quote for Elated', () => {
        expect(quotes).to.have.property('Elated');
    });

    it('should have a quote for Angry', () => {
        expect(quotes).to.have.property('Angry');
    });

    it('should have a quote for Anxious', () => {
        expect(quotes).to.have.property('Anxious');
    });
});
