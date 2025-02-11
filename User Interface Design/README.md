```markdown
# Assignment 4 - User Interface Design

## **1. Introduction**
RedMoon Fantasy is an **online MMORPG** originally developed for **Windows NT-based systems**. Due to compatibility challenges with newer **Windows operating systems** such as **Windows 8, 10, and 11**, the project aims to enhance **cross-version compatibility across all Windows platforms**. The UI serves as an essential interface for user interaction, including **account management, ranking views, online tracking, and in-game store purchases**. Additionally, the project focuses on **refining the CSS for improved usability** and ensuring **full compliance with ADA Level 2 accessibility standards**, which have not yet been fully implemented. 

These improvements will make the interface **more accessible and user-friendly**, aligning with **modern design standards** while maintaining the game’s **legacy functionality**.

---

## **2. Use Case Scenarios**

### **Scenario 1: Creating a New Account**
- The user navigates to the **Add Account** screen.
- They enter their **login credentials, password, and security questions**.
- Optionally, they enable **Hardcore Mode**, which permanently deletes a character upon in-game death.
- The user submits the form, and their **account is created**.

### **Scenario 2: Viewing Player Rankings**
- The user accesses the **Rankings** page.
- They browse **top players categorized by level, rebirth count, and bonus points**.
- They distinguish **Normal and Hardcore accounts via icons**.

### **Scenario 3: Checking Online Players**
- The user navigates to the **Online** page.
- They see a list of **currently logged-in players, along with their account types**.

### **Scenario 4: Purchasing Items from the Store**
- The user opens the **Store** page.
- They enter their **Game ID** and browse available items.
- They select items, add them to the **cart**, and proceed to **checkout via PayPal**.

### **Scenario 5: Accessing Helpful Tools & Game Guides**
- The user clicks on **Tools**, which provides **links to guides, maps, and troubleshooting resources**.

### **Scenario 6: Contributing to the Game**
- The user visits the **Contribution** page.
- They see **progress towards a server-wide event** (e.g., Double EXP).
- They **make a donation** and view their **contribution details**.

---

## **3. Task Analysis**
Each UI component follows a structured workflow to facilitate a seamless user experience:

- **Add Account:** User fills out a form, submits, and **account creation is validated**.
- **Rankings:** Data is **retrieved dynamically from SQL Server** and displayed in a **sortable table**.
- **Online Players:** A **real-time connection fetches the online status** of players.
- **Store:** Users **interact with dynamic purchase options** before finalizing transactions via **PayPal**.
- **Tools:** **Links provide direct access** to key information.
- **Contributions:** A **dynamic progress bar updates** based on donation amounts.

---

## **4. UI Designs for Each Screen**

### **1. Add Account Screen**
- **Fields:** Login ID, Password, Confirm Password, Secret Question, Secret Answer.
- **Checkbox:** Hardcore Mode.
- **Submission button for account creation.**

### **2. Rankings Page**
- **Table with columns:** Army Names, Commander, Camp, Level, Rebirth Count, Bonus Points, Hardcore Mode Indicator.
- **Players are visually distinguished based on account type.**

### **3. Online Players Page**
- **Table displaying currently online players.**
- **Hardcore accounts are marked with a distinct icon.**

### **4. Tools & Guides Page**
- **List of useful resources such as:**
  - Game Guide
  - Map Levels
  - Skill List
  - Un-Stuck
  - Delete Character
  - Rebirth
  - BattleMatch Guide
  - Honor Change

### **5. Store Page**
- **Game ID input field for user identification.**
- **Grid-style product layout, featuring descriptions and prices.**
- **PayPal integration for secure payments.**

### **6. Contributions Page**
- **Dynamic progress bar displaying event funding percentage.**
- **Latest contribution records.**
- **List of event incentives.**

### **7. Contact Page**
- **Input fields:** Email, Title, Message.
- **Submission button to send inquiries.**

---

## **5. Cognitive Walkthrough & Heuristic Evaluation**

### **Walkthrough Assessment**
- **Navigation:** Easy access to all major sections via **top navigation bar**.
- **Form Validation:** Ensuring **required fields are filled correctly**.
- **Accessibility:** Simple, **readable font**; **contrasting colors for readability**.

### **Heuristic Evaluation**
- **Visibility of system status:** Online players and rankings **update in real time**.
- **Match between system and real world:** **Clear labels for all buttons and fields**.
- **User control and freedom:** Store transactions allow for **item removal before purchase**.
- **Consistency and standards:** UI follows a **consistent color scheme and layout**.
- **Error prevention:** Validations ensure **proper data entry (e.g., passwords match)**.
- **Recognition rather than recall:** Icons for **Hardcore vs. Normal accounts** provide **quick identification**.
- **Flexibility and efficiency of use:** Users can **navigate using links** without unnecessary steps.
- **Aesthetic and minimalist design:** **Clean interface with simple navigation**.
- **Help users recognize and recover from errors:** Alerts and **validation messages guide users**.

---

## **6. Shortcuts for Data Entry Screens**
For **standard data entry forms** (e.g., Add Account, Contact Form, Store Checkout), a **generic template** can be applied:
- **Input Fields:** Label, Input Box, Validation Message.
- **Button:** Submit or Cancel.
- **Success/Error Messages:** Display **appropriate feedback upon submission**.

---

## **7. Conclusion & Submission Details**
This UI documentation serves as a **comprehensive guide** to **design, accessibility, and functionality** within the **RedMoon Fantasy** project.
```

