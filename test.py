import matplotlib.pyplot as plt
import numpy as np
import pandas as pd
from sklearn import datasets
from sklearn.neighbors import KNeighborsClassifier
from sklearn.preprocessing import LabelEncoder
import sklearn.metrics as sm
from sklearn import metrics
from collections import Counter

# Load dataset
df = pd.read_csv("C:\Users\acer\Desktop\degree\sem5\CSC649\testingbaking.csv") #Reading the dataset in a dataframe using Pandas
df.head()