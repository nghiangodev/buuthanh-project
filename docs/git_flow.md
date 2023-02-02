1. Checkout code mới nhất từ branch develop
    ```bash
   git checkout develop
   git pull
   ```

1. Tạo branch: **feature/new-feature** từ branch develop
    ```bash
   git checkout -b feature/new-feature develop
   ```

1. Push branch **feature/new-feature** lên origin
  ```bash
   git push -u origin feature/new-feature
   ```

1. Commit code vào branch **feature/new-feature** local
    ```bash
   git add .
   git commit -m "Noi dung feature"
   ```

1. Sau khi làm xong push code lên **origin/feature/new-feature**
    ```bash
   git push origin feature/new-feature
   ```

1. Tạo merge request: 
  1. Source branch là **feature/new-feature**
  1. Target branch là **develop**
  
1. Sau khi **feature/new-feature** được merge, checkout code mới từ branch develop
    ```bash
   git checkout develop
   git pull
   ```

1. Xóa branch **feature/new-feature** ở local và server
  ```bash
   git push -d origin feature/new-feature
   git branch -d feature/new-feature
   ```