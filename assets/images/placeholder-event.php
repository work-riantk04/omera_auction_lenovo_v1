<?php
header('Content-Type: image/svg+xml');
echo '<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="400" viewBox="0 0 1200 400">
<defs>
<linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
<stop offset="0%" style="stop-color:#0a0a0f"/>
<stop offset="100%" style="stop-color:#1a1a2e"/>
</linearGradient>
</defs>
<rect fill="url(#bg)" width="1200" height="400"/>
<text x="600" y="180" text-anchor="middle" fill="#7c3aed" font-family="Arial" font-size="48" font-weight="bold">OMERA AUCTION</text>
<text x="600" y="230" text-anchor="middle" fill="#666" font-family="Arial" font-size="18">Event Banner</text>
<line x1="400" y1="260" x2="800" y2="260" stroke="#7c3aed" stroke-width="2"/>
</svg>';
