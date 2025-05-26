import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import obfuscatorPlugin from "vite-plugin-javascript-obfuscator";

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.tsx',
            refresh: true,
        }),
        react(),
        obfuscatorPlugin({
            include: [
                "resources/js/**/*.js",
                "resources/js/**/*.jsx",
                "resources/js/**/*.ts",
                "resources/js/**/*.tsx",
                /foo.js$/
            ],
            exclude: ['/node_modules/'],
            apply: "build",
            debugger: true,
            options: {
                // your javascript-obfuscator options
                compact: true,
                controlFlowFlattening: true,
                controlFlowFlatteningThreshold: 1,
                deadCodeInjection: true,
                debugProtection: true,
                debugProtectionInterval: 0,
                disableConsoleOutput: true,
                identifierNamesGenerator: 'hexadecimal',
                log: true,
                numbersToExpressions: true,
                renameGlobals: false,
                selfDefending: true,
                simplify: true,
                splitStrings: true,
                ignoreImports: true,
                stringArray: true,
                stringArrayCallsTransform: true,
                stringArrayCallsTransformThreshold: 1,
                stringArrayEncoding: ['rc4'],
                stringArrayIndexShift: true,
                stringArrayRotate: true,
                stringArrayShuffle: true,
                stringArrayWrappersCount: 7,
                stringArrayWrappersChainedCalls: true,
                stringArrayWrappersParametersMaxCount: 7,
                stringArrayWrappersType: 'variable',
                stringArrayThreshold: 1,
                unicodeEscapeSequence: true
            },
        }),
    ],
});
