document.addEventListener('DOMContentLoaded', () => {
    const googleClientId = '350239869325-gjhc0ajkrakq1ol1vbo7t6ov2mjhtdlh.apps.googleusercontent.com';
    const facebookAppId = '1397930070906342';

    document.getElementById('google-login').addEventListener('click', () => {
        window.location.href = `https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=${googleClientId}&redirect_uri=http://localhost/SpendEase/backend/src/components/google-callback.php&scope=email%20profile&access_type=online`;
    });

    document.getElementById('facebook-login').addEventListener('click', () => {
        window.location.href = `https://www.facebook.com/v9.0/dialog/oauth?client_id=${facebookAppId}&redirect_uri=http://localhost/SpendEase/backend/src/components/facebook-callback.php&scope=email`;
    });
});
