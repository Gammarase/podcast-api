<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Content Creator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #1a1a1a;
            color: #e0e0e0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            padding: 2rem;
            min-height: 100vh;
        }

        /* Container styling */
        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Heading styles */
        h1 {
            color: #ff6b00;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 1.5rem;
            background-color: #252525;
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid #333;
            transition: border-color 0.3s ease;
        }

        .form-group:hover {
            border-color: #ff6b00;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            color: #ff6b00;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 4px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b00;
            box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.2);
        }

        /* Error message styling */
        .error {
            color: #ff4444;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            padding-left: 0.5rem;
            border-left: 2px solid #ff4444;
        }

        /* Button styling */
        button {
            width: 100%;
            padding: 1rem;
            background-color: #ff6b00;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        button:hover:not(:disabled) {
            background-color: #ff8533;
            transform: translateY(-1px);
        }

        button:active:not(:disabled) {
            transform: translateY(0);
        }

        button:disabled {
            background-color: #666;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Response message styling */
        #response-message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 4px;
            text-align: center;
        }

        #response-message p {
            font-size: 1rem;
        }

        #response-message p:not(.error) {
            color: #00ff9d;
            background-color: rgba(0, 255, 157, 0.1);
            padding: 1rem;
            border-radius: 4px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .form-group {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <h1>Become a Content Creator</h1>
    <form id="content-creator-form">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <div class="error" id="error-name"></div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <div class="error" id="error-email"></div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="error" id="error-password"></div>
        </div>

        <button type="submit">Submit</button>
    </form>

    <div id="response-message"></div>

    <script>
        const form = document.getElementById('content-creator-form');
        const responseMessage = document.getElementById('response-message');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            responseMessage.innerHTML = '';

            // Clear previous error messages
            ['name', 'email', 'password'].forEach(field => {
                document.getElementById(`error-${field}`).innerText = '';
            });

            const csrfToken = document.querySelector('input[name="_token"]').value;

            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            try {
                const response = await fetch('/request/apply', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Include CSRF token here
                        'Accept': "application/json",
                    },
                    body: JSON.stringify(formData)
                });

                if (!response.ok) {
                    const errorData = await response.json();

                    if (response.status === 422 && errorData.errors) {
                        for (const field in errorData.errors) {
                            const errorElement = document.getElementById(`error-${field}`);
                            if (errorElement) {
                                errorElement.innerText = errorData.errors[field][0];
                            }
                        }
                        responseMessage.innerHTML = `<p class="error">${errorData.message}</p>`;
                    } else {
                        responseMessage.innerHTML = `<p class="error">An unexpected error occurred.</p>`;
                    }
                } else {
                    responseMessage.innerHTML = `<p>Request submitted successfully!</p>`;
                    form.reset();
                }
            } catch (error) {
                responseMessage.innerHTML = `<p class="error">Failed to connect to the server.</p>`;
                console.error('Error:', error);
            }
        });
    </script>
</body>

</html>
