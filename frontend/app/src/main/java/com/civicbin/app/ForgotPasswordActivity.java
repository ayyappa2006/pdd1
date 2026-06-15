package com.civicbin.app;

import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

public class ForgotPasswordActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forgot_password);

        EditText etEmail = findViewById(R.id.etEmail);
        EditText etNewPassword = findViewById(R.id.etNewPassword);
        Button btnSave = findViewById(R.id.btnSave);
        TextView tvBackToLogin = findViewById(R.id.tvBackToLogin);

        btnSave.setOnClickListener(v -> {
            String email = etEmail.getText().toString();
            String newPassword = etNewPassword.getText().toString();
            
            if (email.isEmpty() || newPassword.isEmpty()) {
                Toast.makeText(this, "Please enter email and new password", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(this, "Saving new password...", Toast.LENGTH_SHORT).show();
                // TODO: Add actual reset logic
            }
        });

        tvBackToLogin.setOnClickListener(v -> {
            finish(); // Returns to LoginActivity
        });
    }
}
