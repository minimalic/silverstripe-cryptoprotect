var progressPercent = 0;

document.addEventListener('DOMContentLoaded', function() {
    const challengeLabel = document.querySelector('label.cryptographicchallenge');
    const challengeField = document.querySelector('[data-challenge-id]');
    const challengeTextSolving = challengeField.getAttribute('data-challenge-text-solving');
    const challengeTextSolved = challengeField.getAttribute('data-challenge-text-solved');

    let nextElement = challengeField.nextElementSibling;

    while (nextElement) {
        if (nextElement.classList && nextElement.classList.contains('form-text')) {
            nextElement.remove();
            break;
        }
        nextElement = nextElement.nextElementSibling;
    }

    const submitButton = document.querySelector('input[type="submit"]');
    const statusContainer = document.createElement('div');
    statusContainer.classList.add('f-challenge-progress');
    statusContainer.innerHTML = `
        <div class="d-flex align-items-center my-3">
            <div class="pe-3">
                <div class="spinner-border ms-auto" aria-hidden="true"></div>
            </div>
            <div class="pe-3">
                <strong role="status">${challengeTextSolving}</strong>
            </div>
        </div>
        <div class="my-3">
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="${progressPercent}" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar" style="width: ${progressPercent}%"></div>
            </div>
        </div>
    `;

    if (challengeLabel && challengeField) {
        challengeLabel.classList.add('visually-hidden');
        challengeField.classList.add('visually-hidden');
    }

    if (submitButton) {
        submitButton.disabled = true;
        challengeField.parentNode.insertBefore(statusContainer, challengeField.nextSibling);
    }

    if (challengeField) {
        const challengeQuestion = challengeField.getAttribute('data-challenge-question');
        const calculationCycles = challengeField.getAttribute('data-challenge-difficulty');

        // solve the challenge and update the answer input field
        solveChallenge(challengeQuestion, calculationCycles).then(solvedHash => {
            challengeField.value = solvedHash;
            if (submitButton) {
                submitButton.disabled = false;
                const statusText = statusContainer.querySelector('strong');
                const spinner = statusContainer.querySelector('.spinner-border');
                if (statusText && spinner) {
                    statusText.textContent = challengeTextSolved;
                    spinner.classList.remove('spinner-border');
                    spinner.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                      <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                    </svg>
                    `;
                    setTimeout(() => {
                        statusContainer.remove();
                    }, 4000);
                }
            }
        });
    }
});

// main hash solving function
async function solveChallenge(question, cycles) {
    let currentHash = await hashString(question);
    const progressContainer = document.querySelector('.cryptographicchallenge .progress');
    const progressBar = document.querySelector('.cryptographicchallenge .progress-bar');
    // const calculationCycles = 200000

    // hash the result x times
    for (let i = 0; i < cycles; i++) {
        currentHash = await hashString(currentHash);

        // update the progress bar every x iterations to reduce DOM updates
        if (i % 200 === 0) {
            requestAnimationFrame(() => {
                progressPercent = ((i + 1) / cycles) * 100;
                // progressPercent = Math.ceil(progressPercent);
                if (progressContainer && progressBar) {
                    progressBar.style.width = `${progressPercent}%`;
                    progressContainer.setAttribute('aria-valuenow', progressPercent);
                }
            });
        }
    }
    progressBar.style.width = `100%`;
    progressContainer.setAttribute('aria-valuenow', 100);

    return currentHash;
}

// hash logic used in 'solveChallenge'
async function hashString(inputStr) {
    const encoder = new TextEncoder();
    const data = encoder.encode(inputStr);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
}
