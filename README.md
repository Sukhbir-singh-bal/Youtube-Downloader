# YouTube Downloader

This project is a YouTube video downloader that allows you to download videos from YouTube without the need for any API or third-party tools. It is built using PHP and utilizes a decrypt function to decrypt encrypted videos.

## Installation Guide

1. Clone the repository to your local machine:
   ```
   git clone https://github.com/your-username/youtube-downloader.git
   ```

2. Navigate to the project directory:
   ```
   cd youtube-downloader
   ```

3. Ensure you have PHP installed on your system. You can check the version using the following command:
   ```
   php -v
   ```

   If PHP is not installed, please follow the official PHP installation guide for your operating system.

4. Start a local PHP server:
   ```
   php -S localhost:8000
   ```

5. Open your web browser and visit `http://localhost:8000` to access the YouTube Downloader.

## Usage

1. Enter the YouTube video URL in the provided input field and press submit button.


   ![image](https://github.com/sukhbir-singh-ciir/ytdownloader/assets/133486488/d1c148ac-71b1-474e-83bc-c793fd41216b)



2. Click the "Download" button to initiate the video download process.


   ![image](https://github.com/sukhbir-singh-ciir/ytdownloader/assets/133486488/8c2fb53c-fcb1-48f1-aa0c-1db91aed18c2)


3. Once the download is complete, the video file will be saved to your local machine.

## Note

Please note that YouTube keeps changing its `base.json` file, which may affect the decrypting method used in this project. As a result, there is a possibility that the downloader may not work for certain videos or if YouTube updates its encryption methods. In such cases, the decrypt function needs to be updated accordingly to ensure compatibility. To update decrypt function please use click on Refresh Decrypt Function on navbar.

## Disclaimer

This project is intended for personal use only. Downloading copyrighted content from YouTube may violate the platform's terms of service and local copyright laws. Please ensure that you comply with the appropriate regulations when using this downloader. The developer(s) of this project are not responsible for any misuse or illegal activities performed with this software.

## Contributing

Contributions are welcome! If you encounter any issues, have suggestions for improvements, or would like to add new features, please submit an issue or a pull request to the GitHub repository.

