<?php

namespace Core;
// New: Import the Validator class from the Core namespace
use Core\Validator;

/**
 * Handles all application-specific validation rules for employee data.
 * This class uses the generic validation methods provided by Core\Validator.
 */

class EmployeeValidator
{
    /**
     * Validates all required and optional fields for an employee record.
     *
     * @param array $data The input data (e.g., $_POST array).
     * @return array An array containing 'errors' and 'bank_formatted' string.
     */
    public static function validate(array $data): array
    {
        $errors = [];

        // --- 1. Basic Required String Checks ---

        // Helper function to check if a required field is missing or empty
        $checkRequiredString = function ($field, $message) use (&$errors, $data) {
            // Validator::string() now correctly refers to Core\Validator::string()
            if (!isset($data[$field]) || !Validator::string($data[$field])) {
                $errors[$field] = $message;
            }
        };

        $checkRequiredString('name', "Name is required");
        $checkRequiredString('position', "Position is required");
        $checkRequiredString('department', "Department is required");
        $checkRequiredString('join_date', "Join date is required");
        $checkRequiredString('graduate_university', "Graduate university is required");
        $checkRequiredString('graduate_degree', "Graduate degree is required");
        $checkRequiredString('DOB', "Date of birth is required");
        $checkRequiredString('gender', "Gender is required");
        $checkRequiredString('nrc_no', "NRC No is required");
        $checkRequiredString('address', "Address is required");
        $checkRequiredString('phone', "Phone is required");
        $checkRequiredString('religion', "Religion is required");


        // --- 2. Specific Validation: Email ---

        if (!isset($data['email']) || !Validator::string($data['email'])) {
            $errors['email'] = "Email is required";
        } elseif (!Validator::email($data['email'])) {
            $errors['email'] = "Please provide a valid email";
        }


        // --- 3. Specific Validation: Bank Account (Complex Logic) ---
        $bankRaw = $data['bank_account'] ?? '';
        $bankDigits = str_replace(' ', '', $bankRaw);

        // Save the formatted version if validation passes, otherwise it's null
        $bankFormatted = null;

        // Validator::string() is used here as well
        if (!Validator::string($bankDigits, 16, 16)) {
            $errors['bank_account'] = "Bank account is required and must be 16 digits";
        } elseif (!ctype_digit($bankDigits)) {
            $errors['bank_account'] = "Bank account must contain only digits";
        } else {
            // Format for storage: group by 4 digits separated by -
            $bankFormatted = implode('-', str_split($bankDigits, 4));
        }
        
        return [
            'errors' => $errors,
            'bank_formatted' => $bankFormatted
        ];
    }
}