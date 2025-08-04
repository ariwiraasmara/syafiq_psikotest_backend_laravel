$urls = Get-Content "urls.txt"
$outputDir = "lighthouse-reports"

New-Item -ItemType Directory -Force -Path $outputDir | Out-Null

foreach ($url in $urls) {
    Write-Host "🚀 Scanning: $url"
    $filename = $url -replace 'https?://', '' -replace '/', '_'
    lighthouse $url `
        --output html `
        --output-path "$outputDir\$filename.html" `
        --only-categories=performance,seo,best-practices,accessibility
}

Write-Host "✅ Semua laporan selesai. Cek folder: $outputDir"
