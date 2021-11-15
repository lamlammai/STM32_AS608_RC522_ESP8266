/* USER CODE BEGIN Header */
/**
  ******************************************************************************
  * @file           : main.c
  * @brief          : Main program body
  ******************************************************************************
  * @attention
  *
  * <h2><center>&copy; Copyright (c) 2021 STMicroelectronics.
  * All rights reserved.</center></h2>
  *
  * This software component is licensed by ST under BSD 3-Clause license,
  * the "License"; You may not use this file except in compliance with the
  * License. You may obtain a copy of the License at:
  *                        opensource.org/licenses/BSD-3-Clause
  *
  ******************************************************************************
  */
/* USER CODE END Header */
/* Includes ------------------------------------------------------------------*/
#include "main.h"
#include "i2c.h"
#include "spi.h"
#include "usart.h"
#include "gpio.h"

/* Private includes ----------------------------------------------------------*/
/* USER CODE BEGIN Includes */
#include "rc522.h"
#include "i2c-lcd.h"
#include "r305.h"
#include "ds1307.h"
#include "flash.h"
#include "stdlib.h"
#include "ringbuf.h"
/* USER CODE END Includes */

/* Private typedef -----------------------------------------------------------*/
/* USER CODE BEGIN PTD */
#define BUF_SIZE (20)


RINGBUF RX_BUF;
uint8_t rx_buffer[BUF_SIZE];
uint8_t tempRX;
uint8_t txdata;

/* USER CODE END PTD */

/* Private define ------------------------------------------------------------*/
/* USER CODE BEGIN PD */
/* USER CODE END PD */

/* Private macro -------------------------------------------------------------*/
/* USER CODE BEGIN PM */
void HAL_UART_RxCpltCallback(UART_HandleTypeDef *huart)
{
 if(huart->Instance == huart3.Instance)
 {
	if(tempRX == 13)
		tempRX = 32;
		if(tempRX == 10)
		tempRX = 32;
		RINGBUF_Put(&RX_BUF, tempRX);
	 HAL_UART_Receive_IT(&huart3, &tempRX,1);
	}
	
}
/* USER CODE END PM */

/* Private variables ---------------------------------------------------------*/

/* USER CODE BEGIN PV */
uint8_t str[MFRC522_MAX_LEN];
uint8_t count ;
uint8_t CardID[5];
uint8_t MyID1[5] = {74 , 142 , 31 , 36 , 255};
uint8_t MyID2[5] = {0xAD, 0x1E, 0xDA, 0x3F, 0x56};
uint8_t dataUDP_permit[]="Ma the hop le ";
uint8_t dataUDP_deny[]="Ma the khong hop le ";
uint8_t esp8266[];

char abd[50];
int8_t tt = 0;
uint8_t id = 4;
int8_t y;
int add ;

#define ADDRESS_DATA_STORAGE	0x800FC00

int ModeDD = 0;
int ModeST;
int status = 0;
//menu
int BUTTON1;
int BUTTON2;
int TAM = 1;
int TONG_MENU1 = 0;
int TONG_MENU2 = 0;
int TONG_DIEMDANH = 0;
int TONG_SETTING = 0;
uint8_t TONG = -1;
int demmenu1 = 0;

void send_uart (char *string)		// CT CON GUI UART CAC GTRI NHDO
{
	uint8_t len = strlen (string);
	HAL_UART_Transmit(&huart3, (uint8_t *) string, len, 1000);  
}


//
DS1307_TIME time = {
	.sec = 0,
	.min = 53,
	.hour = 8,
	.day = 6,
	.date = 12,
	.month = 10,
	.year = 21,
};



uint8_t buf0[25];
uint8_t buf1[25];
uint8_t buf3[25];
/* USER CODE END PV */

/* Private function prototypes -----------------------------------------------*/
void SystemClock_Config(void);
/* USER CODE BEGIN PFP */

/* USER CODE END PFP */

/* Private user code ---------------------------------------------------------*/
/* USER CODE BEGIN 0 */
void themvantay()
{
	add = Flash_Read_Int(ADDRESS_DATA_STORAGE);
	if(verifyPassword() == 1 )
			{
				if(fingerEnroll(add) == 1)
				{
						HAL_Delay(1000);
						LCD_setCursor(1,1);
						LCD_sendString("id: ");
						LCD_Write(add/10 + 0x30);
						LCD_Write(add%10 + 0x30);
				}
				else
				{
				HAL_Delay(1500);
				}
			}
}
void XoaVanTay()
{
	if(verifyPassword() == 1 )
	{
		y = fingerIDSearch();
		deleteModel(y);
		LCD_setCursor(1,1);
		LCD_sendString("id: ");
		LCD_Write(y/10 + 0x30);
		LCD_Write(y%10 + 0x30);
		HAL_Delay(1000);
		LCD_setCursor(1,1);
		LCD_sendString("Da Xoa");
	}
}
void XoaToanBo()
{
	if(verifyPassword() == 1 )
	{
		emptyDatabase();
		LCD_setCursor(1,1);
		LCD_sendString("Da Xoa");
	}
}

void Vantay()
{
	
	if(verifyPassword() == 1 )
	{
		y = fingerIDSearch();  // ID
		if(y == -1)
		{
			// LOI
			LCD_setCursor(1,1);
			LCD_sendString("loi                ");
			HAL_Delay(1000);
		}
		else
		{
			if(y==1 )
			{
				LCD_setCursor(1,1);
				LCD_sendString("found-Dung ");
				HAL_Delay(2000);
			}

		  if(y==2)
			{
				LCD_setCursor(1,1);
				LCD_sendString("found-Viet ");
				HAL_Delay(2000);
			}
		  if(y==3)
			{
				LCD_setCursor(1,1);
				LCD_sendString("found-Hung ");
				HAL_Delay(2000);
			}
		if((y == y) && (y != 3) && (y != 2)&& (y != 1)  )
			{
				LCD_setCursor(1,1);
				LCD_sendString("id: ");
				LCD_Write(y/10 + 0x30);
				LCD_Write(y%10 + 0x30);
				HAL_Delay(2000);
			}
		}
	}
}
//
void RFID()
{
	 //LCD_Clear();

	while(1)
	{
		if (TM_MFRC522_Check(CardID) == MI_OK) ///RFID
		{
			sprintf((uint8_t*) buf3, "%d%d%d%d",CardID[0],CardID[1],CardID[2],CardID[3]);
			HAL_UART_Transmit(&huart3, buf3,8,100);
			HAL_Delay(2000);
			if(rx_buffer[0] == 32)
			{
				LCD_setCursor(1,1);	
				LCD_sendString("khong co the");
				RINGBUF_Clear(&RX_BUF,20);
				break;
			}
			else 
			{
				LCD_setCursor(1,1);	
				LCD_sendString(rx_buffer);
				RINGBUF_Clear(&RX_BUF,20);
				break;
			}		
		}
	}
	
}

void ThoiGian()
{
		GET_TIME(&time);
		sprintf((char*) buf0, "%02d/%02d/20%02d", time.date, time.month, time.year);
		sprintf((char*) buf1, "%02d:%02d:%02d", time.hour, time.min, time.sec);
		LCD_setCursor(0,3);
		LCD_sendString(buf0);
		LCD_setCursor(1,4);
		LCD_sendString(buf1);
}
//

void MENU_TONG()
{
  if (TONG == 0)
  {
    LCD_Clear();
		 LCD_setCursor(0, 6);
    LCD_sendString("DO AN 2");
    LCD_setCursor(2, 1);
    LCD_sendString(">DiemDanh");
    LCD_setCursor(3, 1);
    LCD_sendString(" SETTING");
  }
  else if (TONG == 1)
  {
    LCD_Clear();
		 LCD_setCursor(0, 6);
    LCD_sendString("DO AN 2");
    LCD_setCursor(2, 1);
    LCD_sendString(" DiemDanh");
    LCD_setCursor(3, 1);
    LCD_sendString(">SETTING");
  }
 
}
//
void MENU1()
{
    if (TONG_MENU1 == 0)
  {
    LCD_Clear();
    LCD_setCursor(1, 1);
    LCD_sendString(">DiemDanhVanTay");
    LCD_setCursor(2, 1);
    LCD_sendString(" RFID");
		LCD_setCursor(3, 1);
    LCD_sendString(" BACK");
  }
  else if (TONG_MENU1 == 1)
  {
    LCD_Clear();
        LCD_setCursor(1, 1);
    LCD_sendString(" DiemDanhVanTay");
    LCD_setCursor(2, 1);
    LCD_sendString(">RFID");
		LCD_setCursor(3, 1);
    LCD_sendString(" BACK");
  }
	 else if (TONG_MENU1 == 2)
  {
    LCD_Clear();
        LCD_setCursor(1, 1);
    LCD_sendString(" DiemDanhVanTay");
    LCD_setCursor(2, 1);
    LCD_sendString(" RFID");
		LCD_setCursor(3, 1);
    LCD_sendString(">BACK");
  }
}
void MENU2()
{    if (TONG_MENU2 == 0)
  {
    LCD_Clear();
    LCD_setCursor(0, 1);
    LCD_sendString(">ADD VANTAY");
    LCD_setCursor(1, 1);
    LCD_sendString(" DELETE 1 VANTAY");
		LCD_setCursor(2, 1);
    LCD_sendString(" DELETE FULL");
		LCD_setCursor(3, 1);
    LCD_sendString(" BACK");
  }
  else if (TONG_MENU2 == 1)
  {
    LCD_Clear();
    LCD_setCursor(0, 1);
    LCD_sendString(" ADD VANTAY");
    LCD_setCursor(1, 1);
    LCD_sendString(">DELETE 1 VANTAY");
		LCD_setCursor(2, 1);
    LCD_sendString(" DELETE FULL");
		LCD_setCursor(3, 1);
    LCD_sendString(" BACK");
  }
	 else if (TONG_MENU2 == 2)
  {
   LCD_Clear();
    LCD_setCursor(0, 1);
    LCD_sendString(" ADD VANTAY");
    LCD_setCursor(1, 1);
    LCD_sendString(" DELETE 1 VANTAY");
		LCD_setCursor(2, 1);
    LCD_sendString(">DELETE FULL");
		LCD_setCursor(3, 1);
    LCD_sendString(" BACK");
  }
	 else if (TONG_MENU2 == 3)
  {
   LCD_Clear();
    LCD_setCursor(0, 1);
    LCD_sendString(" ADD VANTAY");
    LCD_setCursor(1, 1);
    LCD_sendString(" DELETE 1 VANTAY");
		LCD_setCursor(2, 1);
    LCD_sendString(" DELETE FULL");
		LCD_setCursor(3, 1);
    LCD_sendString(">BACK");
  }
}
void MENU_DIEMDANH()
{
	switch(TONG_MENU1)
	{
		case 0:
			LCD_Clear();
      LCD_setCursor(0,1);
      LCD_sendString("DiemDanhVanTay");
			Vantay();
			HAL_Delay(1000);
			break;
		case 1:
			LCD_Clear();
      LCD_setCursor(0,8);
      LCD_sendString("RFID");
			RFID();
			HAL_Delay(1000);
			break;
	}
}
void MENU_SETTING()
{
if (TONG_MENU2 == 0)
  {
			LCD_Clear();
      LCD_setCursor(0,1);
      LCD_sendString("ADD VAN TAY");
			themvantay();
      add++;
			Flash_Erase(ADDRESS_DATA_STORAGE);
			Flash_Write_Int(ADDRESS_DATA_STORAGE,add);
  }
  else if (TONG_MENU2 == 1)
  {
			LCD_Clear();
      LCD_setCursor(0,1);
      LCD_sendString("DELETE 1 VANTAY");	
			XoaVanTay();
  }
	 else if (TONG_MENU2 == 2)
  {
			LCD_Clear();
      LCD_setCursor(0,1);
      LCD_sendString("DELETE FULL");	
			XoaToanBo();
			Flash_Erase(ADDRESS_DATA_STORAGE);
			Flash_Write_Int(ADDRESS_DATA_STORAGE,0);
  }
}
/* USER CODE END 0 */

/**
  * @brief  The application entry point.
  * @retval int
  */
int main(void)
{
  /* USER CODE BEGIN 1 */

  /* USER CODE END 1 */

  /* MCU Configuration--------------------------------------------------------*/

  /* Reset of all peripherals, Initializes the Flash interface and the Systick. */
  HAL_Init();

  /* USER CODE BEGIN Init */

  /* USER CODE END Init */

  /* Configure the system clock */
  SystemClock_Config();

  /* USER CODE BEGIN SysInit */

  /* USER CODE END SysInit */

  /* Initialize all configured peripherals */
  MX_GPIO_Init();
  MX_SPI1_Init();
  MX_I2C1_Init();
  MX_USART1_UART_Init();
  MX_USART3_UART_Init();
  /* USER CODE BEGIN 2 */
	TM_MFRC522_Init();
  LCD_Init();
  I2C_Config(&hi2c1);
  SET_TIME(&time);
	RINGBUF_Init(&RX_BUF, rx_buffer, BUF_SIZE);
	HAL_UART_Receive_IT(&huart3, &tempRX,1) ;
			TM_MFRC522_Init();
  /* USER CODE END 2 */

  /* Infinite loop */
  /* USER CODE BEGIN WHILE */
  while (1)
  {
    /* USER CODE END WHILE */

    /* USER CODE BEGIN 3 */
		 BUTTON1 = HAL_GPIO_ReadPin(GPIOA, GPIO_PIN_1);
		 BUTTON2 = HAL_GPIO_ReadPin(GPIOA, GPIO_PIN_2);

		//BUTTON LEN 
		if(BUTTON1 != 1)
		{
			 if(BUTTON1 == 0)
		 {
			 if(TAM == 1)  // menu tong
			 {
			 if(TONG >=1 )
				 TONG = 0;
			 else
				 TONG++;
			 	MENU_TONG();
			}
			if(TAM == 2 && TONG == 0) // chon menu diemdanh
			 {
			 if(TONG_MENU1 >=2 )
				 TONG_MENU1 = 0;
			 else
				 TONG_MENU1++;
			 	MENU1();
			}
			if(TAM == 2 && TONG == 1) // chon menusetting
			 {
			 if(TONG_MENU2 >=3 )
				 TONG_MENU2 = 0;
			 else
				 TONG_MENU2++;
			 	MENU2();
			}
			 HAL_Delay(200);
			}
		}
		
			
			// BUTTON MENU
			if(BUTTON2 ==0 )
			{
				TAM ++;
				
				if(TAM == 1)
					MENU_TONG();
				else if(TAM == 2 && TONG == 0) // chon menu1
				{
					MENU1();
					demmenu1 ++;
				}
				else if(TAM == 2 && TONG == 1) // chon menu2
				{
					MENU2();
					demmenu1 ++;
				}
				else if(TAM == 3 && TONG == 0 &&  TONG_MENU1 < 2  && demmenu1 == 1) // chon menu o menu 1
				{
					MENU_DIEMDANH();
				}
				else if(TAM == 3 && TONG == 1 &&  TONG_MENU2 < 3  && demmenu1 == 1) // chon menu o menu 1
				{
					MENU_SETTING();
				}
				else if(TAM == 4 && TONG == 0 &&  TONG_MENU1 < 2 && demmenu1 == 1) // thoat chon menu 1
				 {
						TAM = 2;
					 TONG = 0;
						MENU1();
				 }
				 else if(TAM == 4 && TONG == 1 &&  TONG_MENU2 < 3 && demmenu1 == 1) // thoat chon menu 2
				 {
						TAM = 2;
					 TONG = 1;
						MENU2();
				 }
				 else if(TAM == 3 && TONG == 0 &&  TONG_MENU1 == 2  && demmenu1 == 1)
				{
					TONG_MENU1 = 0;
					TAM = 1;
					demmenu1 = 0;
					MENU_TONG();
				}
				 else if(TAM == 3 && TONG == 1 &&  TONG_MENU2 == 3  && demmenu1 == 1)
				{
					TONG_MENU2 = 0;
					TAM = 1;
					demmenu1 = 0;
					MENU_TONG();
				}

				 HAL_Delay(200);
			}
		
  }
  /* USER CODE END 3 */
}

/**
  * @brief System Clock Configuration
  * @retval None
  */
void SystemClock_Config(void)
{
  RCC_OscInitTypeDef RCC_OscInitStruct = {0};
  RCC_ClkInitTypeDef RCC_ClkInitStruct = {0};

  /** Initializes the RCC Oscillators according to the specified parameters
  * in the RCC_OscInitTypeDef structure.
  */
  RCC_OscInitStruct.OscillatorType = RCC_OSCILLATORTYPE_HSE;
  RCC_OscInitStruct.HSEState = RCC_HSE_ON;
  RCC_OscInitStruct.HSEPredivValue = RCC_HSE_PREDIV_DIV1;
  RCC_OscInitStruct.HSIState = RCC_HSI_ON;
  RCC_OscInitStruct.PLL.PLLState = RCC_PLL_ON;
  RCC_OscInitStruct.PLL.PLLSource = RCC_PLLSOURCE_HSE;
  RCC_OscInitStruct.PLL.PLLMUL = RCC_PLL_MUL9;
  if (HAL_RCC_OscConfig(&RCC_OscInitStruct) != HAL_OK)
  {
    Error_Handler();
  }
  /** Initializes the CPU, AHB and APB buses clocks
  */
  RCC_ClkInitStruct.ClockType = RCC_CLOCKTYPE_HCLK|RCC_CLOCKTYPE_SYSCLK
                              |RCC_CLOCKTYPE_PCLK1|RCC_CLOCKTYPE_PCLK2;
  RCC_ClkInitStruct.SYSCLKSource = RCC_SYSCLKSOURCE_PLLCLK;
  RCC_ClkInitStruct.AHBCLKDivider = RCC_SYSCLK_DIV1;
  RCC_ClkInitStruct.APB1CLKDivider = RCC_HCLK_DIV2;
  RCC_ClkInitStruct.APB2CLKDivider = RCC_HCLK_DIV1;

  if (HAL_RCC_ClockConfig(&RCC_ClkInitStruct, FLASH_LATENCY_2) != HAL_OK)
  {
    Error_Handler();
  }
}

/* USER CODE BEGIN 4 */

/* USER CODE END 4 */

/**
  * @brief  This function is executed in case of error occurrence.
  * @retval None
  */
void Error_Handler(void)
{
  /* USER CODE BEGIN Error_Handler_Debug */
  /* User can add his own implementation to report the HAL error return state */
  __disable_irq();
  while (1)
  {
  }
  /* USER CODE END Error_Handler_Debug */
}

#ifdef  USE_FULL_ASSERT
/**
  * @brief  Reports the name of the source file and the source line number
  *         where the assert_param error has occurred.
  * @param  file: pointer to the source file name
  * @param  line: assert_param error line source number
  * @retval None
  */
void assert_failed(uint8_t *file, uint32_t line)
{
  /* USER CODE BEGIN 6 */
  /* User can add his own implementation to report the file name and line number,
     ex: printf("Wrong parameters value: file %s on line %d\r\n", file, line) */
  /* USER CODE END 6 */
}
#endif /* USE_FULL_ASSERT */

/************************ (C) COPYRIGHT STMicroelectronics *****END OF FILE****/
