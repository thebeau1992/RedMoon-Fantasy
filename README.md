# RedMoon Fantasy - Online MMORPG

🚀 **RedMoon Fantasy** is an online MMORPG where players download the game executable directly from the website. This project modernizes the game’s distribution using a custom launcher/installer built via Inno Setup, PHP scripts for backend integration, Node.js for real-time communication, and a suite of modern web technologies for front-end presentation. The system leverages SQL Server 2022 for game data, XAMPP (Apache) for web hosting, Cloudflare for SSL/DDoS protection, and No-IP for dynamic DNS.

> **Note:** The installer performs registry edits, file linking, and configuration to ensure seamless local execution.

---

## 📌 1. System Components & Installed Software

| **Component**                | **Version** | **Installation Status** | **Notes**                                                                                         |
|------------------------------|-------------|-------------------------|---------------------------------------------------------------------------------------------------|
| XAMPP (Apache, MySQL)        | Latest      | ✅ Installed            | Web hosting and file sharing/uploads/downloads                                                    |
| SQL Server 2022              | Latest      | ✅ Installed            | Game database and backend data management                                                         |
| Python                       | Latest      | ✅ Installed            | Used for auxiliary scripts and automation                                                         |
| PHP                          | Latest      | ✅ Installed            | Provides connection strings, API endpoints, etc.                                                  |
| Node.js                      | Latest      | ✅ Installed            | WebSocket server and middleware flow                                                              |
| Cloudflare Proxy             | N/A         | ✅ Configured           | SSL & DDoS protection                                                                               |
| No-IP Dynamic DNS            | N/A         | ✅ Configured           | Dynamic DNS: Public domain `redmoonfantasy.ddns.net`                                                |
| Inno Setup Compiler          | Latest      | ✅ Installed            | For building the game installer/launcher                                                          |
| Registry Editor (RegEdits)   | N/A         | ✅ Configured           | Custom tweaks for game behavior (e.g., window focus)                                              |
| **Front-End Development**    | HTML/CSS/JS | ✅ Implemented          | Modern, responsive download portal using HTML, CSS, and JavaScript to enhance the user experience  |

---

## 🌐 2. Hosting & Deployment Environments

| **Stage**     | **URL**                      | **Hosting Details**         | **Notes**                                |
|---------------|------------------------------|-----------------------------|------------------------------------------|
| Development   | `localhost`                  | XAMPP on local Windows      | Internal testing and debugging           |
| Testing       | `redmoon-fantasy.com`        | Cloudflare Proxy            | Staging environment with SSL             |
| Production    | `redmoonfantasy.ddns.net`      | No-IP DDNS (Public)         | Public domain (dynamic IP masked)        |

---

## 🔄 3. Architecture & Workflow

- **Game Launcher & Installer:**  
  The game executable is packaged using Inno Setup. The installer/wrapper performs necessary registry edits, file linking, and configuration so the game runs seamlessly on the local machine.
  
- **Server & API Integration:**  
  PHP scripts manage connection strings to the SQL Server database, handle online player counts and rankings, and integrate with the PayPal API for the in-game store. Python scripts support additional server-side automation and maintenance tasks.
  
- **Real-Time Communication:**  
  A custom Node.js WebSocket server handles real-time multiplayer communication, ensuring smooth gameplay and live updates.
  
- **File & Resource Management:**  
  XAMPP (Apache) hosts game files (e.g., DLLs, data files). The installer ensures that all necessary files are correctly installed and linked on the client’s system.

- **Website Navigation & Tools:**  
  The main website (redmoon-fantasy.com) includes navigation tabs such as **Home**, **Add Account**, **Rankings**, **Online**, **Tools**, **Store**, **Contributions**, and **Contact**. Additional links include:
  - **Client Download**
  - **RedMoon Utilities Program** – a comprehensive tool for in-game quality-of-life (QOL) features.
  - Within the **Tools** tab, players will find QOL links such as:  
    - Lotto Ticket Items  
    - Game Guide  
    - Troubleshooting  
    - Map Levels (with in-progress integration for in-game maps)  
    - Custom Items  
    - Skill List  
    - Un-Stuck  
    - Delete Character  
    - Rebirth  
    - BattleMatchGuide  
    - Honor Change  

---

## 🔄 4. WebSocket API Events

| **Event**       | **Description**                                  | **Request Format**                          | **Response Format**                             |
|-----------------|--------------------------------------------------|---------------------------------------------|-------------------------------------------------|
| `launchGame`    | Player presses "Enter" in the launcher           | `{ "type": "launchGame" }`                  | `{ "type": "executeGame" }`                     |
| `spawn`         | Game instance signals readiness                  | `{ "type": "spawn" }`                       | `{ "success": true }`                           |
| `downloadGame`  | Client initiates download of RedMoon.exe         | `{ "type": "downloadGame" }`                | `{ "type": "success" }`                         |
| `checkFile`     | Verifies file presence on the client side        | `{ "type": "checkFile", "path": "/RMFiles" }` | `{ "type": "fileStatus", "exists": true }`      |

---

## 📁 5. File Structure & Distribution

| **File/Folder**         | **Distribution Location**                          | **Status**  |
|-------------------------|----------------------------------------------------|-------------|
| RMFSetup.exe            | Download available on website                      | ✅ Ready    |
| RedMoon.exe             | RedMoon Fantasy Launcher (packaged in installer)     | ✅ Ready    |
| DesDll.dll              | Packaged in installer                              | ✅ Ready    |
| Main.dll                | Packaged in installer                              | ✅ Ready    |
| rm3944cl.dll            | Packaged in installer                              | ✅ Ready    |
| info.dll                | Packaged in installer                              | ✅ Ready    |
| chigamec.dll            | Packaged in installer                              | ✅ Ready    |
| **DATAs/ folder**       | Packaged in installer                              | ✅ Ready    |
| **RLEs/ folder**        | Packaged in installer                              | ✅ Ready    |
| D3D8.dll                | Packaged in installer                              | ✅ Ready    |
| D3D9.dll                | Packaged in installer                              | ✅ Ready    |
| D3Dlmm.dll              | Packaged in installer                              | ✅ Ready    |
| Dfx_p5s.dll             | Packaged in installer                              | ✅ Ready    |
| Dfc_p6s.dll             | Packaged in installer                              | ✅ Ready    |
| ExStage.dll             | Packaged in installer                              | ✅ Ready    |
| Message.dll             | Packaged in installer                              | ✅ Ready    |
| MFC42.dll               | Packaged in installer                              | ✅ Ready    |
| PrxyAuth.dll            | Packaged in installer                              | ✅ Ready    |
| Red2.dll                | Packaged in installer                              | ✅ Ready    |
| rmDB.dll                | Packaged in installer                              | ✅ Ready    |
| Staff.dll               | Packaged in installer                              | ✅ Ready    |
| Staff3.dll              | Packaged in installer                              | ✅ Ready    |
| Uninstall.exe           | Packaged in installer                              | ✅ Ready    |

---

## 🚧 6. Feature Development Progress

| **Feature**                    | **Description**                                            | **Status**       | **Notes**                                      |
|--------------------------------|------------------------------------------------------------|------------------|------------------------------------------------|
| Game Launcher Wrapper          | Custom launcher via Inno Setup and registry edits          | ✅ Completed     | Currently under minor adjustment (minimize issue) |
| Database & API Integration     | SQL Server 2022 with PHP for connection strings            | ✅ Completed     | Real-time player data and PayPal store integrated  |
| WebSocket Server               | Real-time multiplayer via Node.js                          | ✅ Completed     | Custom middleware for game events               |
| File & Resource Management     | Automated file linking via installer                       | ✅ Completed     | Missing .dll file issue persists                |
| Auto-Download RedMoon.exe      | Direct download trigger from website                       | ✅ Completed     | Verified on client systems                      |
| Window Behavior Fix            | Prevent game window from minimizing unexpectedly           | 🔄 In Progress   | Game currently minimizes twice on launch        |

---

## ✅ 7. Testing Procedures & Status

| **Test Case**                      | **Expected Result**                             | **Status**        |
|------------------------------------|-------------------------------------------------|-------------------|
| Game download from website         | RedMoon.exe downloads successfully               | ✅ Passed         |
| Installer completes successfully   | All required game files are installed and linked   | ✅ Passed         |
| Game launches without minimizing   | Game window remains active                        | 🔄 In Progress    |
| WebSocket connects                 | "WebSocket Connected!" message displayed           | ✅ Passed         |
| Verify DLL presence on client      | All necessary .dll files are detected              | 🔄 In Progress    |

---

## 🔜 8. Next Steps & Pending Fixes

| **Task**                         | **Description**                                      | **Priority** | **Status**        |
|----------------------------------|------------------------------------------------------|--------------|-------------------|
| Fix game window minimizing issue | Prevent duplicate minimization events on launch       | 🔥 High      | 🔄 In Progress    |
| Resolve missing .dll file issues | Automate file copy or symlink for all dependencies     | 🔥 High      | 🔄 In Progress    |
| Optimize WebSocket handling      | Eliminate redundant reconnections                     | 🟡 Medium    | ✅ Done           |
| Automate update deployment       | Auto-deploy latest executable via GitHub              | 🟡 Medium    | 🔄 In Progress    |
| Enhance file integrity checks    | Validate file uploads/downloads and file status         | 🔵 Low       | Not Started       |

---

## 📜 9. Version History

| **Version** | **Changes & Improvements**                                                              |
|-------------|-----------------------------------------------------------------------------------------|
| v1.0        | Initial setup: Launcher wrapper, PHP integration, and WebSocket                           |
| v1.1        | Added auto-download of RedMoon.exe and basic file linking fix                              |
| v1.2        | Integrated SQL Server 2022 and updated PHP connection scripts                              |
| v1.3        | Implemented custom WebSocket middleware & auto-reconnect mechanisms                        |
| v1.4        | Optimized file distribution; initial fix for DLL linking issues                            |
| v1.5        | Fixed duplicate game minimization issue (partial fix)                                      |
| v2.0        | Major rework: Unified launcher with cross-platform compatibility                           |
| v2.1        | Enhanced API security with Cloudflare and dynamic DNS via No-IP                              |
| v2.2        | Ongoing: Fine-tuning game execution and file linking management                            |

---

## 📌 10. Change Management Process

| **Step**        | **Process**                                         |
|-----------------|-----------------------------------------------------|
| **Development** | Branch: `dev` → Implement and test new features      |
| **Testing**     | Branch: `test` → Debug and validate functionality    |
| **Approval**    | Code review & GitHub Pull Request                    |
| **Deployment**  | Merge to `main` → Auto-deploy via CI/CD pipeline       |

---

📌 **[GitHub Repository](https://github.com/thebeau1992/redmoon)**  
📢 **This document is under active development. Contributions and suggestions are welcome!** 🚀
