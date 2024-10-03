<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CRM Registration Update</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    table {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .header {
      background-color: #4CAF50;
      padding: 20px;
      color: white;
      text-align: center;
    }
    .content {
      padding: 20px;
    }
    .content h1 {
      font-size: 24px;
      color: #333333;
    }
    .content p {
      font-size: 16px;
      color: #666666;
      line-height: 1.6;
    }
    .cta-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 12px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .footer {
      background-color: #f4f4f4;
      text-align: center;
      padding: 10px;
      font-size: 14px;
      color: #888888;
    }
    .social-icons img {
      width: 32px;
      margin: 0 5px;
    }
    @media screen and (max-width: 600px) {
      table {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<table>
  <tr>
    <td class="header">
      <h2>CRM Registration Update</h2>
    </td>
  </tr>
  <tr>
    <td class="content">
      <h1>Hello, [Client's Name]!</h1>
      <p>We are excited to inform you that your registration on our CRM platform has been successfully updated. Your details have been verified, and you are all set to start using our services.</p>

      <p>If you have any questions or need assistance, please feel free to contact our support team at any time.</p>

      <a href="[CRM Dashboard URL]" class="cta-btn">Go to Dashboard</a>
    </td>
  </tr>
  <tr>
    <td class="footer">
      <p>Thank you for choosing our CRM platform!</p>
      <p>If you didn't request this registration update, please <a href="mailto:support@crm.com">contact us</a> immediately.</p>

      <div class="social-icons">
        <!-- <a href="#"><img src="facebook-icon.png" alt="Facebook"></a> -->
        <!-- <a href="#"><img src="twitter-icon.png" alt="Twitter"></a> -->
        <!-- <a href="#"><img src="linkedin-icon.png" alt="LinkedIn"></a> -->
      </div>
      <p>&copy; 2024 CRM Inc. All rights reserved.</p>
    </td>
  </tr>
</table>

<script>
  // Example JavaScript for basic interaction (optional)
  document.querySelector('.cta-btn').addEventListener('click', function() {
    alert('Redirecting you to the dashboard...');
  });
</script>

</body>
</html>