import React from 'react';
import { render } from 'react-dom';
import '@elderbraum/rvk-elements';

export function renderStarsInput() {
    const targets = document.querySelectorAll('.re-stars-input');

    if (targets.length === 0) {
        return;
    }

    targets.forEach(target => render(React.createElement(rvkElements.Input.Stars, {
        input: {
            id:'score'
        }
    }), target));
}

