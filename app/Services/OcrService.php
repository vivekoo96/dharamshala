<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;

class OcrService
{
    /**
     * Extract text from an image using Tesseract OCR
     */
    public function extractText(string $imagePath): string
    {
        try {
            $ocr = new TesseractOCR($imagePath);
            return $ocr->run();
        } catch (\Exception $e) {
            \Log::error('OCR extraction failed: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Extract structured data from Aadhaar card image
     */
    public function extractAadhaarData(string $imagePath): array
    {
        $text = $this->extractText($imagePath);

        return [
            'name' => $this->extractName($text),
            'aadhaar_number' => $this->extractAadhaarNumber($text),
            'address' => $this->extractAddress($text),
            'raw_text' => $text
        ];
    }

    /**
     * Extract Aadhaar number (12 digits, may have spaces)
     */
    private function extractAadhaarNumber(string $text): ?string
    {
        // Pattern: XXXX XXXX XXXX or XXXXXXXXXXXX
        if (preg_match('/\b(\d{4}\s?\d{4}\s?\d{4})\b/', $text, $matches)) {
            return str_replace(' ', '', $matches[1]);
        }
        return null;
    }

    /**
     * Extract name (usually 2-3 capitalized words near the top)
     */
    private function extractName(string $text): ?string
    {
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);

            // Look for lines with 2-4 capitalized words (likely a name)
            if (preg_match('/^([A-Z][a-z]+\s){1,3}[A-Z][a-z]+$/', $line)) {
                return $line;
            }
        }

        return null;
    }

    /**
     * Extract address (multi-line text, usually after specific keywords)
     */
    private function extractAddress(string $text): ?string
    {
        // Look for address after keywords like "Address:", "S/O", "D/O", etc.
        $lines = explode("\n", $text);
        $addressLines = [];
        $capturing = false;

        foreach ($lines as $line) {
            $line = trim($line);

            // Start capturing after address-related keywords
            if (preg_match('/(Address|S\/O|D\/O|C\/O)/i', $line)) {
                $capturing = true;
            }

            // Capture subsequent lines that look like address components
            if ($capturing && !empty($line) && !preg_match('/\d{4}\s?\d{4}\s?\d{4}/', $line)) {
                $addressLines[] = $line;

                // Stop after collecting a few lines
                if (count($addressLines) >= 3) {
                    break;
                }
            }
        }

        return !empty($addressLines) ? implode(', ', $addressLines) : null;
    }

    /**
     * Check if Tesseract is installed and available
     */
    public function isAvailable(): bool
    {
        try {
            $ocr = new TesseractOCR();
            $ocr->version();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
